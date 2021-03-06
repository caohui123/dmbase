<?php

/*
 * 基于MIT开源协议发布
 *
 * (c) Efeen Cheung <261969254@qq.com>
 *
 * 有事请联系QQ:261969254, 微信:efeencheung, Github:efeencheung
 */

namespace Dm\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Dm\Bundle\AttachmentBundle\Entity\Picture;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, \Serializable 
{
    /**
     * ID
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * 用户名
     *
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank(message="该选项是必填项，不能为空", groups={"create"})
     * @Assert\Regex(pattern="/^[0-9a-z]{4,18}$/", message="输入格式不正确", groups={"create"})
     */
    private $username;

    /**
     * 密码
     *
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\NotBlank(message="该选项是必填项，不能为空", groups={"create"})
     * @Assert\Length(min=4, max=18, minMessage="密码长度为4-18位", maxMessage="密码长度为4-18位", groups={"create", "edit"})
     */
    private $password;

    /**
     * 显示名称
     *
     * @var string
     *
     * @ORM\Column(name="showname", type="string", length=255)
     * @Assert\NotBlank(message="该选项是必填项，不能为空", groups={"create", "edit"})
     */
    private $showname;

    /**
     * 创建时间
     *
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * 更新时间
     *
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /** 
     * 用户角色
     *  
     * @var \Dm\Bundle\SecurityBundle\Entity\Role
     *
     * @ORM\ManyToOne(targetEntity="\Dm\Bundle\SecurityBundle\Entity\Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;

    /**
     * @var Picture
     * 
     * @ORM\ManyToOne(targetEntity="\Dm\Bundle\AttachmentBundle\Entity\Picture", cascade={"all"})
     * @ORM\JoinColumn(name="picture_id", referencedColumnName="id")
     */
    private $avatar;
   

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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set showname
     *
     * @param string $showname
     * @return User
     */
    public function setShowname($showname)
    {
        $this->showname = $showname;

        return $this;
    }

    /**
     * Get showname
     *
     * @return string 
     */
    public function getShowname()
    {
        return $this->showname;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        if ($this->role instanceof \Dm\Bundle\SecurityBundle\Entity\Role)
        {
            $role = $this->role->getRole();
            return array($role);
        } else {
            return array('ROLE_USER');
        }
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function getSalt()  
    {
        return null;           
    }

    /**
     * Set role
     *
     * @param \Dm\Bundle\SecurityBundle\Entity\Role $role
     * @return User
     */
    public function setRole(\Dm\Bundle\SecurityBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Dm\Bundle\SecurityBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }
 
    /**
     * Set avatar
     *
     * @param \Dm\Bundle\AttachmentBundle\Entity\Picture
     * @return User
     */
    public function setAvatar(Picture $avatar)
    {
        $this->avatar = $avatar;
    
        return $this;
    }
    
    /**
     * Get avatar
     *
     * @return \Dm\Bundle\AttachmentBundle\Entity\Picture
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getName()
    {
        if ($this->showname !== null) {
            return $this->showname;
        }

        return $this->username;
    }

    /** 
     * @see \Serializable::serialize() 
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /** 
     * @see \Serializable::unserialize() 
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }
}
