<?php

namespace Codebender\LibraryBundle\Handler\ApiCommand;

use Codebender\LibraryBundle\Entity\Version;
use Symfony\Component\Finder\Finder;

class FetchApiCommand extends AbstractApiCommand
{
    protected $apiHandler;

    public function execute($content)
    {
        if (!array_key_exists('library', $content)) {
            return ["success" => false, "message" => "You need to specify which library to fetch."];
        }

        $content = $this->setDefault($content);
        $filename = $content['library'];

        $last_slash = strrpos($filename, "/");
        if ($last_slash !== false) {
            $filename = substr($filename, $last_slash + 1);
        }

        $this->apiHandler = $this->container->get('codebender_library.apiHandler');

        $externalLibrariesPath = $this->container->getParameter('external_libraries_v2');

        $finder = new Finder();
        $exampleFinder = new Finder();

        //TODO handle the case of different .h filenames and folder names
        $reservedNames = ["ArduinoRobot" => "Robot_Control", "ArduinoRobotMotorBoard" => "Robot_Motor",
            "BlynkSimpleSerial" => "BlynkSimpleEthernet", "BlynkSimpleCC3000" => "BlynkSimpleEthernet"];

        if (array_key_exists($filename, $reservedNames)) {
            $filename = $reservedNames[$filename];
        }

        if (!$this->apiHandler->isLibrary($filename, $content['disabled'])) {
            return ["success" => false, "message" => "No Library named " . $filename . " found."];
        }

        // check if requested (if any) version is valid
        if ($content['version'] !== null && !$this->apiHandler->libraryVersionExists($filename, $content['version'])) {
            return [
                'success' => false,
                'message' => 'No files for Library named `' . $filename . '` with version `' . $content['version'] . '` found.'
            ];
        }

        $versionObjects = $this->apiHandler->getAllVersionsFromDefaultHeader($filename);

        // fetch default version
        // if rendering view, fetch all versions
        // if specifically asked for a certain version, fetch that version
        // else if specifically asked for latest version, fetch latest version
        $versions = [$this->apiHandler->fetchPartnerDefaultVersion($this->getRequest()->get('authorizationKey'), $filename)];
        if ($content['renderView'] && $content['version'] === null) {
            $versions = $versionObjects->toArray();
        }
        if ($content['version'] !== null) {
            $versionsCollection = $versionObjects->filter(function ($version) use ($content) {
                return $version->getVersion() === $content['version'];
            });
            $versions = $versionsCollection->toArray();
        }
        if ($content['latest']) {
            $lib = $this->apiHandler->getLibraryFromDefaultHeader($filename);
            $versions = [$lib->getLatestVersion()];
        }

        if (array_key_exists('v1', $content) && $content['v1']) {
            // fetch library files for each version
            $response = [];
            $examples = [];

            $version = $this->apiHandler->fetchPartnerDefaultVersion($this->getRequest()->get('authorizationKey'), $filename);

            /* @var Version $version */
            $libraryPath = $externalLibrariesPath . "/" . $filename . "/" . $version->getFolderName();

            // fetch library files for this version
            $fetchResponse = $this->apiHandler->fetchLibraryFiles($finder->create(), $libraryPath);
            if (!empty($fetchResponse)) {
                $response = $fetchResponse;
            }

            if ($content['renderView']) {
                // fetch example files for this version if it's rendering view
                $exampleResponse = $this->apiHandler->fetchLibraryExamples($exampleFinder->create(), $libraryPath);
                if (!empty($exampleResponse)) {
                    $examples[$version->getVersion()] = $exampleResponse;
                }
            }

            if ($content['renderView']) {
                $externalLibrary = $this->entityManager->getRepository('CodebenderLibraryBundle:Library')
                    ->findOneBy(array('default_header' => $filename));
                $filename = $externalLibrary->getDefaultHeader();
                $meta = $externalLibrary->getLibraryMeta();

                $result = [
                    'success' => true,
                    'library' => $filename,
                    'files' => $response,
                    'examples' => $examples,
                    'meta' => $meta
                ];
            } else {
                $result = ['success' => true, 'message' => 'Library found', 'files' => $response];
            }
        } else {
            // fetch library files for each version
            $response = [];
            $examples = [];
            foreach ($versions as $version) {
                /* @var Version $version */
                $libraryPath = $externalLibrariesPath . "/" . $filename . "/" . $version->getFolderName();
                // fetch library files for this version
                $fetchResponse = $this->apiHandler->fetchLibraryFiles($finder->create(), $libraryPath);
                if (!empty($fetchResponse)) {
                    $response[$version->getVersion()] = $fetchResponse;
                }
                if ($content['renderView']) {
                    // fetch example files for this version if it's rendering view
                    $exampleResponse = $this->apiHandler->fetchLibraryExamples($exampleFinder->create(), $libraryPath);
                    if (!empty($exampleResponse)) {
                        $examples[$version->getVersion()] = $exampleResponse;
                    }
                }
            }
            if ($content['renderView']) {
                $externalLibrary = $this->entityManager->getRepository('CodebenderLibraryBundle:Library')
                    ->findOneBy(array('default_header' => $filename));
                $filename = $externalLibrary->getDefaultHeader();
                $meta = $externalLibrary->getLibraryMeta();
                $versions = array_map(
                    function ($version) {
                        return $version->getVersionMeta();
                    },
                    $versions
                );
                $result = [
                    'success' => true,
                    'library' => $filename,
                    'versions' => $versions,
                    'files' => $response,
                    'examples' => $examples,
                    'meta' => $meta
                ];
            } else {
                $result = ['success' => true, 'message' => 'Library found', 'files' => $response];
            }
        }

        return $result;
    }

    private function setDefault($content)
    {
        $content['disabled'] = (array_key_exists('disabled', $content) ? $content['disabled'] : false);
        $content['version'] = (array_key_exists('version', $content) ? $content['version'] : null);
        $content['latest'] = (array_key_exists('latest', $content) ? $content['latest'] : false);
        $content['renderView'] = (array_key_exists('renderView', $content) ? $content['renderView'] : false);
        if (!array_key_exists('disabled', $content)) {
            $content['disabled'] = false;
        }
        if (!array_key_exists('version', $content)) {
            $content['version'] = null;
        }
        if (!array_key_exists('renderView', $content)) {
            $content['renderView'] = false;
        }
        return $content;
    }
}
