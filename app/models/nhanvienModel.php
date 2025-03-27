<?php

class NhanVienModel {
    private $db;

    public function __construct($db) {
        $this->db = $db; 
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM NHANVIEN");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO NHANVIEN (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['Ma_NV'], $data['Ten_NV'], $data['Phai'], $data['Noi_Sinh'], $data['Ma_Phong'], $data['Luong']]);
    }

    public function delete($ma_nv) {
        $stmt = $this->db->prepare("DELETE FROM NHANVIEN WHERE Ma_NV = ?");
        return $stmt->execute([$ma_nv]);
    }

    public function update($ma_nv, $data) {
        $stmt = $this->db->prepare("UPDATE NHANVIEN SET Ten_NV = ?, Phai = ?, Noi_Sinh = ?, Ma_Phong = ?, Luong = ? WHERE Ma_NV = ?");
        return $stmt->execute([$data['Ten_NV'], $data['Phai'], $data['Noi_Sinh'], $data['Ma_Phong'], $data['Luong'], $ma_nv]);
    }

    public function find($ma_nv) {
        $stmt = $this->db->prepare("SELECT * FROM NHANVIEN WHERE Ma_NV = ?");
        $stmt->execute([$ma_nv]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>