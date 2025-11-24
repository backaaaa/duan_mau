<?php
require_once './models/BaseModel.php';

class ProductModel extends BaseModel
{
    protected $table = 'products';

    public function all()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql  = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createWithVariants($data, $variants)
    {
        try {
            $this->pdo->beginTransaction();

            // insert product
            $sql = "INSERT INTO {$this->table}
                    (id_danh_muc, ten_san_pham, gia, anh_dai_dien, mo_ta)
                    VALUES (:id_danh_muc, :ten_san_pham, :gia, :anh_dai_dien, :mo_ta)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'id_danh_muc'  => $data['id_danh_muc'],
                'ten_san_pham' => $data['ten_san_pham'],
                'gia'          => $data['gia'],
                'anh_dai_dien' => $data['anh_dai_dien'],
                'mo_ta'        => $data['mo_ta'],
            ]);

            $productId = $this->pdo->lastInsertId();

            // insert variants
            $sqlVar   = "INSERT INTO product_variants (product_id, size, mau_sac, so_luong)
                         VALUES (:product_id, :size, :mau_sac, :so_luong)";
            $stmtVar  = $this->pdo->prepare($sqlVar);

            foreach ($variants as $v) {
                if (empty($v['size']) || $v['so_luong'] === '') continue;

                $stmtVar->execute([
                    'product_id' => $productId,
                    'size'       => $v['size'],
                    'mau_sac'    => $v['mau_sac'],
                    'so_luong'   => $v['so_luong'],
                ]);
            }

            $this->pdo->commit();
            return $productId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function updateWithVariants($id, $data, $variants)
    {
        try {
            $this->pdo->beginTransaction();

            // update product
            $sql = "UPDATE {$this->table}
                    SET id_danh_muc = :id_danh_muc,
                        ten_san_pham = :ten_san_pham,
                        gia = :gia,
                        anh_dai_dien = :anh_dai_dien,
                        mo_ta = :mo_ta,
                        ngay_cap_nhat = NOW()
                    WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'id_danh_muc'  => $data['id_danh_muc'],
                'ten_san_pham' => $data['ten_san_pham'],
                'gia'          => $data['gia'],
                'anh_dai_dien' => $data['anh_dai_dien'],
                'mo_ta'        => $data['mo_ta'],
                'id'           => $id,
            ]);

            // xóa toàn bộ biến thể cũ và insert lại cho đơn giản
            $stmtDel = $this->pdo->prepare("DELETE FROM product_variants WHERE product_id = :id");
            $stmtDel->execute(['id' => $id]);

            $sqlVar  = "INSERT INTO product_variants (product_id, size, mau_sac, so_luong)
                        VALUES (:product_id, :size, :mau_sac, :so_luong)";
            $stmtVar = $this->pdo->prepare($sqlVar);

            foreach ($variants as $v) {
                if (empty($v['size']) || $v['so_luong'] === '') continue;

                $stmtVar->execute([
                    'product_id' => $id,
                    'size'       => $v['size'],
                    'mau_sac'    => $v['mau_sac'],
                    'so_luong'   => $v['so_luong'],
                ]);
            }

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function deleteWithVariants($id)
    {
        try {
            $this->pdo->beginTransaction();

            $stmtDelVar = $this->pdo->prepare("DELETE FROM product_variants WHERE product_id = :id");
            $stmtDelVar->execute(['id' => $id]);

            $stmtDelProduct = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
            $stmtDelProduct->execute(['id' => $id]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function getVariantsByProduct($productId)
    {
        $sql  = "SELECT * FROM product_variants WHERE product_id = :id ORDER BY size";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
