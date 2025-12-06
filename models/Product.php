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
            $sqlVar = "INSERT INTO product_variants (product_id, size, mau_sac, anh_mau, so_luong)
                        VALUES (:product_id, :size, :mau_sac, :anh_mau, :so_luong)";
            $stmtVar  = $this->pdo->prepare($sqlVar);

            foreach ($variants as $v) {
                if (empty($v['size']) || $v['so_luong'] === '') continue;

                $stmtVar->execute([
                    'product_id' => $productId,
                    'size'       => $v['size'],
                    'mau_sac'    => $v['mau_sac'],
                    'anh_mau'    => $v['anh_mau'] ?? '',
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

            $sqlVar = "INSERT INTO product_variants (product_id, size, mau_sac, anh_mau, so_luong)
                        VALUES (:product_id, :size, :mau_sac, :anh_mau, :so_luong)";
            $stmtVar = $this->pdo->prepare($sqlVar);

            foreach ($variants as $v) {
                if (empty($v['size']) || $v['so_luong'] === '') continue;

                $stmtVar->execute([
                    'product_id' => $id,
                    'size'       => $v['size'],
                    'mau_sac'    => $v['mau_sac'],
                    'anh_mau'    => $v['anh_mau'] ?? '',
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

    public function getVariantsByProductId($productId)
    {
        $sql = "SELECT * FROM product_variants WHERE product_id = :id ORDER BY mau_sac, size";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


        // Đếm tổng số sản phẩm cho client (theo keyword + danh mục)
    public function countForClient($keyword = '', $cateId = '')
    {
        $sql    = "SELECT COUNT(*) FROM {$this->table} WHERE 1";
        $params = [];

        // tìm theo tên sản phẩm
        if ($keyword !== '') {
            $sql .= " AND ten_san_pham LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        // lọc theo danh mục
        if ($cateId !== '') {
            $sql .= " AND id_danh_muc = :cate_id";
            $params[':cate_id'] = $cateId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn();
    }

    // Lấy danh sách sản phẩm cho client (có phân trang, tìm kiếm, filter cate)
    public function getForClient($keyword = '', $cateId = '', $limit = 12, $offset = 0)
    {
        $sql    = "SELECT * FROM {$this->table} WHERE 1";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND ten_san_pham LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if ($cateId !== '') {
            $sql .= " AND id_danh_muc = :cate_id";
            $params[':cate_id'] = $cateId;
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        // bind các param string
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        // bind limit, offset kiểu int
        $stmt->bindValue(':limit',  (int)$limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // Lấy các sản phẩm mới nhất cho trang chủ
    public function getLatest($limit = 8)
    {
        $limit = (int)$limit; // tránh lỗi injection

        $sql = "SELECT *
                FROM {$this->table}
                ORDER BY ngay_tao DESC, id DESC
                LIMIT {$limit}";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
