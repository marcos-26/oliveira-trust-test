<?php

namespace App\Models;

use App\Domain\Repository\ManagerRepository;
use App\Models\Maneger\Estacionamento;

class Manager extends ManagerRepository
{

    /** @attributes
     * $_id
     * $nome
     * $email
     * $telefone
     * $whatssap
     * $mensagem
     * $endereco
     * $estacionamento
     * $created_at
     */

    public static function factory(): Manager
    {
        return app()->make(Manager::class);
    }

    public function save(array $options = [])
    {
        parent::save();
        ($this->endereco) ? parent::endereco()->save($this->endereco) : null;
        ($this->estacionamento) ? parent::estacionamento()->save($this->estacionamento) : null;
    }

    public function populate(array $data): self
    {
        (!empty($data['_id'])) ? $this->_id = $data['_id'] : null;
        (isset($data['nome'])) ? $this->nome = $data['nome'] ?? '' : null;
        (isset($data['email'])) ? $this->email = $data['email'] ?? '' : null;
        (isset($data['telefone'])) ? $this->telefone = $data['telefone'] ?? '' : null;
        (isset($data['whatssap'])) ? $this->whatssap = $data['whatssap'] ?? '' : null;
        (isset($data['mensagem'])) ? $this->mensagem = $data['mensagem'] ?? '' : null;
        (!empty($data['endereco'])) ? $this->endereco = Endereco::factory()->populate($data['endereco'])->toArray() : null;
        (!empty($data['estacionamento'])) ? $this->estacionamento = Estacionamento::factory()->populate($data['estacionamento'])->toArray() : null;
        (!empty($data['created_at'])) ? $this->created_at = $data['created_at'] : null;
        return $this;
    }

    /**
     * Get the value of _id
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set the value of _id
     *
     * @return  self
     */

    public function setId($_id)
    {
        $this->_id = $_id;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @return  self
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of telefone
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set the value of telefone
     *
     * @return  self
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get the value of mensagem
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * Set the value of mensagem
     *
     * @return  self
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;

        return $this;
    }

    /**
     * Get the value of whatssap
     */
    public function getWhatssap()
    {
        return $this->whatssap;
    }

    /**
     * Set the value of whatssap
     *
     * @return  self
     */
    public function setWhatssap($whatssap)
    {
        $this->whatssap = $whatssap;

        return $this;
    }

    /**
     * Get the value of estacionamento
     */
    public function getEstacionamento(): ?Estacionamento
    {
        return $this->estacionamento;
    }

    /**
     * Set the value of estacionamento
     *
     * @return  self
     */
    public function setEstacionamento(Estacionamento $estacionamento)
    {
        $this->estacionamento = $estacionamento;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of endereco
     */
    public function getEndereco(): ?Endereco
    {
        return $this->endereco;
    }

    /**
     * Set the value of endereco
     *
     * @return  self
     */
    public function setEndereco(Endereco $endereco)
    {
        $this->endereco = $endereco;

        return $this;
    }
}
