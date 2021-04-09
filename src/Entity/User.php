<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="user", orphanRemoval=true)
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=SocialMediaAccount::class, mappedBy="user", orphanRemoval=true)
     */
    private $socialMediaAccounts;


    /**
     * @ORM\OneToMany(targetEntity=TemplatePost::class, mappedBy="user", orphanRemoval=true)
     */
    private $templatePosts;


    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->socialMediaAccounts = new ArrayCollection();

        $this->templatePosts = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SocialMediaAccount[]
     */
    public function getSocialMediaAccounts(): Collection
    {
        return $this->socialMediaAccounts;
    }


    public function addSocialMediaAccount(SocialMediaAccount $socialMediaAccount): self
    {
        if (!$this->socialMediaAccounts->contains($socialMediaAccount)) {
            $this->socialMediaAccounts[] = $socialMediaAccount;
            $socialMediaAccount->setUser($this);
        }

        return $this;
    }

    public function removeSocialMediaAccount(SocialMediaAccount $socialMediaAccount): self
    {
        if ($this->socialMediaAccounts->removeElement($socialMediaAccount)) {
            // set the owning side to null (unless already changed)
            if ($socialMediaAccount->getUser() === $this) {
                $socialMediaAccount->setUser(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|TemplatePost[]
     */
    public function getTemplatePosts(): Collection
    {
        return $this->templatePosts;
    }

    public function addTemplatePost(TemplatePost $templatePost): self
    {
        if (!$this->templatePosts->contains($templatePost)) {
            $this->templatePosts[] = $templatePost;
            $templatePost->setUser($this);
        }

        return $this;
    }

    public function removeTemplatePost(TemplatePost $templatePost): self
    {
        if ($this->templatePosts->removeElement($templatePost)) {
            // set the owning side to null (unless already changed)
            if ($templatePost->getUser() === $this) {
                $templatePost->setUser(null);
            }
        }

        return $this;
    }

}
