<?php
class ProductVariant {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getByProduct($product_id) {
        $sql = "SELECT * FROM product_variants WHERE product_id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createVariant($product_id, $mau, $sizes) {
        foreach ($sizes as $size => $qty) {
            $sql = "INSERT INTO product_variants(product_id, size, mau_sac, so_luong)
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$product_id, $size, $mau, $qty]);
        }
    }

    public function deleteByProduct($product_id) {
        $stmt = $this->db->prepare("DELETE FROM product_variants WHERE product_id=?");
        $stmt->execute([$product_id]);
    }
}
