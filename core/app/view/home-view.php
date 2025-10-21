<?php
$found = false;
$products = ProductData::getAll();
$products_array = [];

foreach ($products as $product) {
    if (isset($product->id) && isset($product->inventary_min)) {
        $q = OperationData::getQYesF($product->id);
        if (is_numeric($q) && $q <= $product->inventary_min) {
            $products_array[] = $product;
        }
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <h1>Bienvenido a Talaveras Martínez</h1>
    </div>
</div>

<div class="row">
    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-primary text-white p-3 me-3">
                    <svg class="icon icon-xl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-smile"></use>
                    </svg>
                </div>
                <div>
                    <div class="fs-6 fw-semibold text-primary"><?php echo count(ProductData::getAll()); ?></div>
                    <div class="text-medium-emphasis text-uppercase fw-semibold small">PRODUCTOS</div>
                </div>
            </div>
            <div class="card-footer px-3 py-2">
                <a class="btn-block text-medium-emphasis d-flex justify-content-between align-items-center" href="./?view=products">
                    <span class="small fw-semibold">IR A PRODUCTOS</span>
                    <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Clientes -->
    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-info text-white p-3 me-3">
                    <svg class="icon icon-xl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                    </svg>
                </div>
                <div>
                    <div class="fs-6 fw-semibold text-info"><?php echo count(PersonData::getClients()); ?></div>
                    <div class="text-medium-emphasis text-uppercase fw-semibold small">CLIENTES</div>
                </div>
            </div>
            <div class="card-footer px-3 py-2">
                <a class="btn-block text-medium-emphasis d-flex justify-content-between align-items-center" href="./?view=clients">
                    <span class="small fw-semibold">IR A CLIENTES</span>
                    <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Proveedores -->
    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-warning text-white p-3 me-3">
                    <svg class="icon icon-xl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-truck"></use>
                    </svg>
                </div>
                <div>
                    <div class="fs-6 fw-semibold text-warning"><?php echo count(PersonData::getProviders()); ?></div>
                    <div class="text-medium-emphasis text-uppercase fw-semibold small">PROVEEDORES</div>
                </div>
            </div>
            <div class="card-footer px-3 py-2">
                <a class="btn-block text-medium-emphasis d-flex justify-content-between align-items-center" href="./?view=providers">
                    <span class="small fw-semibold">IR A PROVEEDORES</span>
                    <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Categorías -->
    <div class="col-6 col-lg-3">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-danger text-white p-3 me-3">
                    <svg class="icon icon-xl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                    </svg>
                </div>
                <div>
                    <div class="fs-6 fw-semibold text-danger"><?php echo count(CategoryData::getAll()); ?></div>
                    <div class="text-medium-emphasis text-uppercase fw-semibold small">CATEGORÍAS</div>
                </div>
            </div>
            <div class="card-footer px-3 py-2">
                <a class="btn-block text-medium-emphasis d-flex justify-content-between align-items-center" href="./?view=categories">
                    <span class="small fw-semibold">IR A CATEGORÍAS</span>
                    <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<br>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">ALERTAS DE INVENTARIO</div>
            <div class="card-body">

                <?php if (count($products_array) > 0): ?>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <th>Código</th>
                            <th>Nombre del producto</th>
                            <th>En Stock</th>
                            <th>Estado</th>
                        </thead>
                        <?php foreach ($products_array as $product): ?>
                            <?php
                            if (!isset($product->id) || !isset($product->inventary_min)) continue;
                            $q = OperationData::getQYesF($product->id);
                            if ($q <= $product->inventary_min):
                                $class = $q == 0 || $q <= ($product->inventary_min / 2) ? 'danger' : 'warning';
                            ?>
                                <tr class="<?= $class ?>">
                                    <td><?= $product->id ?></td>
                                    <td><?= $product->name ?></td>
                                    <td><?= $q ?></td>
                                    <td>
                                        <?php if ($q == 0): ?>
                                            <span class="label label-danger">No hay existencias.</span>
                                        <?php elseif ($q <= ($product->inventary_min / 2)): ?>
                                            <span class="label label-danger">Quedan muy pocas existencias.</span>
                                        <?php else: ?>
                                            <span class="label label-warning">Quedan pocas existencias.</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </table>

                <?php else: ?>
                    <div class="jumbotron">
                        <h2>No hay alertas</h2>
                        <p>Por el momento no hay alertas de inventario. Estas se muestran cuando el inventario ha alcanzado el nivel mínimo.</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
