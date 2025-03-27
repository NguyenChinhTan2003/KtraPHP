<?php

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, fullname, email, role_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['username'], $data['password'], $data['fullname'], $data['email'], $data['role_id']]);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE Id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE users SET username = ?, password = ?, fullname = ?, email = ?, role_id = ? WHERE Id = ?");
        return $stmt->execute([$data['username'], $data['password'], $data['fullname'], $data['email'], $data['role_id'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE Id = ?");
        return $stmt->execute([$id]);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>