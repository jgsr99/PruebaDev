<?php require_once INCLUDES.'inc_header.php'; ?>

<!-- Content Row -->
<div class="row">

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-primary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Inventario</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo sprintf('<a href="inventarios">%s</a>', 'Agregar inventario'); ?></div>
					</div>
					<div class="col-auto">
						<i class="fa-solid fa-shop fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Entregas de compras</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><a href="entregasCompras">Ver entregas pendientes</a></div>
					</div>
					<div class="col-auto">
						<i class="fa-light fa-cart-circle-arrow-up fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example 
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Lecciones</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><a href="alumno/lecciones">Continuar</a></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-layer-group fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>-->
</div>

<?php require_once INCLUDES.'inc_footer.php'; ?>