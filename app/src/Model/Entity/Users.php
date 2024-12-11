<?php

namespace App\Model\Entity;

use Symplefony\Model\Entity;

class Users extends Entity
{
    protected string $email;
    public function getEmail(): string { return $this->email; }
    public function setEmail( string $email ): self
    {
        $this->email = $email;
        return $this;
    }

    protected string $password;
    public function getPassword(): string { return $this->password; }
    public function setPassword( string $password ): self
    {
        $this->password = $password;
        return $this;
    }

    protected string $firstname;
    public function getFirstname(): string { return $this->firstname; }
    public function setFirstname( string $firstname ): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    protected string $lastname;
    public function getLastname(): string { return $this->lastname; }
    public function setLastname( string $lastname ): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    protected string $phone_number;
    public function getPhone_number(): string { return $this->phone_number; }
    public function setPhone_number( string $phone_number ): self
    {
        $this->phone_number = $phone_number;
        return $this;
    }
    
}