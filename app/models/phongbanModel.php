<?php
class PhongBanModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM PHONGBAN");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO PHONGBAN (Ma_Phong, Ten_Phong) VALUES (?, ?)");
        return $stmt->execute([$data['Ma_Phong'], $data['Ten_Phong']]);
    }

    public function delete($ma_phong) {
        $stmt = $this->db->prepare("DELETE FROM PHONGBAN WHERE Ma_Phong = ?");
        return $stmt->execute([$ma_phong]);
    }

    public function update($ma_phong, $data) {
        $stmt = $this->db->prepare("UPDATE PHONGBAN SET Ten_Phong = ? WHERE Ma_Phong = ?");
        return $stmt->execute([$data['Ten_Phong'], $ma_phong]);
    }

    public function find($ma_phong) {
        $stmt = $this->db->prepare("SELECT * FROM PHONGBAN WHERE Ma_Phong = ?");
        $stmt->execute([$ma_phong]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>