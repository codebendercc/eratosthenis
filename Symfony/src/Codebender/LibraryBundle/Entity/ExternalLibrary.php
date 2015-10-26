<?php

namespace Codebender\LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExternalLibrary
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ExternalLibrary
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="humanName", type="string", length=255)
     */
    private $humanName;

    /**
     * @var string
     *
     * @ORM\Column(name="machineName", type="string", length=255)
     */
    private $machineName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2048)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=255, nullable = true)
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="repo", type="string", length=255, nullable = true)
     */
    private $repo;

    /**
     * @var string
     *
     * @ORM\Column(name="branch", type="string", length=255, nullable = true)
     */
    private $branch;

    /**
     * @var string
     *
     * @ORM\Column(name="in_repo_path", type="string", length=255, nullable = true)
     */
    private $inRepoPath;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable = true)
     */
    private $notes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="verified", type="boolean")
     */
    private $verified;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="lastCommit", type="string", length=255, nullable = true)
     */
    private $lastCommit;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=512, nullable = true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="source_url", type="string", length=512, nullable = true)
     */
    private $sourceUrl;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set humanName
     *
     * @param string $humanName
     * @return ExternalLibrary
     */
    public function setHumanName($humanName)
    {
        $this->humanName = $humanName;
    
        return $this;
    }

    /**
     * Get humanName
     *
     * @return string 
     */
    public function getHumanName()
    {
        return $this->humanName;
    }

    /**
     * Set machineName
     *
     * @param string $machineName
     * @return ExternalLibrary
     */
    public function setMachineName($machineName)
    {
        $this->machineName = $machineName;
    
        return $this;
    }

    /**
     * Get machineName
     *
     * @return string 
     */
    public function getMachineName()
    {
        return $this->machineName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ExternalLibrary
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return htmlspecialchars($this->description);
    }

    /**
     * Set owner
     *
     * @param string $owner
     * @return ExternalLibrary
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return string 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set repo
     *
     * @param string $repo
     * @return ExternalLibrary
     */
    public function setRepo($repo)
    {
        $this->repo = $repo;
    
        return $this;
    }

    /**
     * Get repo
     *
     * @return string 
     */
    public function getRepo()
    {
        return $this->repo;
    }

    /**
     * Set branch
     *
     * @param string $branch
     * @return ExternalLibrary
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;
        return $this;
    }

    /**
     * Get branch
     *
     * @return string
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Set inRepoPath
     *
     * @param string $inRepoPath
     * @return ExternalLibrary
     */
    public function setInRepoPath($inRepoPath)
    {
        $this->inRepoPath = $inRepoPath;
        return $this;
    }

    /**
     * Get inRepoPath
     *
     * @return string
     */
    public function getInRepoPath()
    {
        return $this->inRepoPath;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return ExternalLibrary
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set verified
     *
     * @param boolean $verified
     * @return ExternalLibrary
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    
        return $this;
    }

    /**
     * Get verified
     *
     * @return boolean 
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return ExternalLibrary
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set lastCommit
     *
     * @param string $lastCommit
     * @return ExternalLibrary
     */
    public function setLastCommit($lastCommit)
    {
        $this->lastCommit = $lastCommit;

        return $this;
    }

    /**
     * Get verified
     *
     * @return string
     */
    public function getLastCommit()
    {
        return $this->lastCommit;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return ExternalLibrary
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set sourceUrl
     *
     * @param string $sourceUrl
     * @return ExternalLibrary
     */
    public function setSourceUrl($sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;

        return $this;
    }

    /**
     * Get sourceUrl
     *
     * @return string
     */
    public function getSourceUrl()
    {
        return $this->sourceUrl;
    }

    /**
     * Get the metadata of the library
     *
     * @return array
     */
    public function getLiraryMeta()
    {
        return array(
            'humanName' => $this->getHumanName(),
            'description' => $this->getDescription(),
            'verified' => $this->getVerified(),
            'gitOwner' => $this->getOwner(),
            'gitRepo' => $this->getRepo(),
            'url' => $this->getUrl(),
            'active' => $this->getActive(),
            'sourceUrl' => $this->getSourceUrl(),
            'gitBranch' => $this->getBranch(),
            'gitLastCommit' => $this->getLastCommit(),
            'gitInRepoPath' => $this->getInRepoPath(),
            'libraryNotes' => $this->getNotes()
        );
    }
}
