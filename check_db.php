<?php
/**
 * Script de diagnóstico para verificar la estructura de la base de datos
 * Ejecutar desde: http://tu-tienda.com/modules/pagosuscriekp/check_db.php
 */

// Cargar PrestaShop
require_once(dirname(__FILE__) . '/../../config/config.inc.php');

echo "<h1>Diagnóstico de Base de Datos - PagoSuscriekp</h1>";

// Verificar tabla pagosuscriekp_plan_installment
echo "<h2>Columnas de pagosuscriekp_plan_installment:</h2>";
$columns = Db::getInstance()->executeS('SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'pagosuscriekp_plan_installment`');
echo "<pre>";
print_r($columns);
echo "</pre>";

// Verificar datos guardados
echo "<h2>Datos de ejemplo (primeros 5 registros):</h2>";
$data = Db::getInstance()->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'pagosuscriekp_plan_installment` LIMIT 5');
echo "<pre>";
print_r($data);
echo "</pre>";

// Verificar si existe la columna fixed_date_month
$has_month = false;
foreach ($columns as $column) {
    if ($column['Field'] == 'fixed_date_month') {
        $has_month = true;
        break;
    }
}

echo "<h2>Estado:</h2>";
if ($has_month) {
    echo "<p style='color: green; font-weight: bold;'>✓ La columna fixed_date_month EXISTE</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>✗ La columna fixed_date_month NO EXISTE</p>";
    echo "<p>Ejecuta este SQL manualmente:</p>";
    echo "<pre>ALTER TABLE `" . _DB_PREFIX_ . "pagosuscriekp_plan_installment` ADD `fixed_date_month` int(11) DEFAULT NULL AFTER `fixed_date_day`;</pre>";
}

echo "<hr>";
echo "<p><strong>IMPORTANTE:</strong> Elimina este archivo después de usarlo por seguridad.</p>";
