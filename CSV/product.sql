CREATE VIEW products
as
    (
    SELECT
        'brand',
        'colour',
        'discount_filter',
        'discount_percentage',
        'discounted_price',
        'id',
        'image',
        'in_stock',
        'material',
        'name',
        'neck',
        'price',
        'product_position',
        'sku',
        'sleeve',
        'status',
        'stock_qty',
        'url' 
    FROM pim_product as p
    LEFT JOIN pim_product_attribute_value as pav ON 'p.id_product' = 'pav.id_product'
    LEFT JOIN pim_product_attribute as pa ON 'pav.id_attribute' = 'pa.id_attribute'
    LEFT JOIN pim_product_categories as pc ON 'p.id_product' = 'pc.id_product'
    LEFT JOIN pim_categories_data as cd ON 'pc.id_catetory' = 'pcd.id_category'
    LEFT JOIN pim_product_gallery as pg ON 'p.id_product' = 'pcd.id_product' AND 'position' = 1
)