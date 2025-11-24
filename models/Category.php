<?php
require_once 'BaseModel.php';

class Category extends BaseModel {

    protected $table = 'categories';

    public function all() {
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        return $this->query_all($sql);
    }

    public function find($id) {
        $sql = "SELECT * FROM $this->table WHERE id = $id";
        return $this->query_one($sql);
    }

    public function create($data) {
        $ten = $data['ten_danh_muc'];
        $mo_ta = $data['mo_ta'];

        $sql = "INSERT INTO $this->table(ten_danh_muc, mo_ta) 
                VALUES ('$ten', '$mo_ta')";
        return $this->execute($sql);
    }

    public function updateCategory($id, $data) {
        $ten = $data['ten_danh_muc'];
        $mo_ta = $data['mo_ta'];

        $sql = "UPDATE $this->table 
                SET ten_danh_muc = '$ten', mo_ta = '$mo_ta', ngay_cap_nhat = NOW()
                WHERE id = $id";
        return $this->execute($sql);
    }

    public function deleteCategory($id) {
        $sql = "DELETE FROM $this->table WHERE id = $id";
        return $this->execute($sql);
    }
    public function findByName($ten) {
    $sql = "SELECT * FROM $this->table WHERE ten_danh_muc = '$ten'";
    return $this->query_one($sql);
}

}
