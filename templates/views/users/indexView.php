<?php require_once INCLUDES.'inc_header.php'; ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
	  <h6 class="m-0 font-weight-bold text-primary"><?php echo $d->title; ?></h6>
  </div>
  <div class="card-body">
		<?php if(!empty($d->users->rows)): ?>
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Nombre completo</th>
							<th>Correo electrónico</th>
							<th>Status</th>
							<th width="10%">Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($d->users->rows as $p): ?>
							<tr>
								<td><?php echo empty($p->nombre_completo) ? '<spand class="text-muted">Sin nombre</spand>' : add_ellipsis($p->nombre_completo, 50); ?></td>
								<td><?php echo empty($p->email) ? '<spand class="text-muted">Sin correo electrónico</spand>' : $p->email; ?></td>
								<td><?php echo format_estado_usuario($p->status); ?></td>
								<td>
									<div class="btn-group">
										<a href="<?php echo 'users/ver/'.$p->id; ?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
										<?php if($p->status === 'suspendido'): ?>
											<button class="btn btn-warning text-dark btn-sm remover_suspension_usuario" data-view="users" data-id="<?php echo $p->id; ?>"><i class="fas fa-undo"></i></button>
										<?php else: ?>
											<button class="btn btn-danger btn-sm suspender_usuario"  data-view="users" data-id="<?php echo $p->id; ?>"><i class="fas fa-ban"></i></button>								
										<?php endif; ?>
										<a href="<?php echo 'users/borrar/'.$p->id; ?>" class="btn btn-sm btn-danger confirmar"><i class="fas fa-trash"></i></a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php echo $d->users->pagination; ?>
			</div>			
		<?php else: ?>
			<div class="py-5 text-center">
				<img src="<?php echo IMAGES."undraw_empty.png"; ?>" alt="No hay registros" style="width: 250px;">
				<p class="text-muted">No hay registro en la base de datos.</p>
			</div>
		<?php endif; ?>		
  </div>
</div>


<?php require_once INCLUDES.'inc_footer.php'; ?>