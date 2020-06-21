<?php
/**
 * Admin page markup
 */

namespace MP_Installer\Admin;
use MP_Installer\Includes as Includes;

$mp_installer = new Includes\MP_Installer();
?>
<div class="wrap pc-wrap">

	<h1><?php _e( 'Install Multiple Plugins', MPI_DOMAIN ) ?></h1>

	<div id="mpiblock">

		<div class="mpi-field-toggle">
			<a href="javascript:void(0);" id="mpi-expand"><?php _e( 'Expand All', MPI_DOMAIN ) ?></a>
			<a href="javascript:void(0);" id="mpi-collapse"><?php _e( 'Collapse All', MPI_DOMAIN ) ?></a>
		</div>

		<div><?php if( $mp_installer->mpi_app_DirTesting()){} else{ _e( '<div class="mpi_error">oops!!! Seems like the directory permission are not set right so some functionalities of plugin will not work.<br/>Please set the directory permission for the folder "uploads" inside "wp-content" directory to 777.</div>', MPI_DOMAIN ); } ?></div>

		<!-- Install Plugins From Wordpress Site -->
		<div id="poststuff" class="mpi-meta-box">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox closed">
					<button type="button" class="handlediv" aria-expanded="false" title="Click to toggle">
						<span class="toggle-indicator" aria-hidden="true"></span>
					</button>
					<h2 class="hndle ui-sortable-handle"><span><?php _e( 'Remote Install', MPI_DOMAIN ); ?></span></h2>
					<div class="inside">
						<form name="form_apu" method="post" action="">
							<fieldset>
								<legend class="screen-reader-text"><?php _e( 'Remote Install', MPI_DOMAIN ); ?></legend>
								<?php wp_nonce_field( $mp_installer->key); ?>
								<div>
									<label for="mpi_expfilenm"><?php _e( 'Enter Exported File Name:', MPI_DOMAIN ); ?></label>
									<br/><input type="text" name="mpi_expfilenm" />

									<p class="description"><?php _e( 'Enter unique name for file without spaces / special charactors.', MPI_DOMAIN ); ?></p>

									<p>
										<label for="mpi_wplists"><?php _e( 'Enter the list of plugins to install.<br />You can specify either the Name or URL of the plugin zip installation file.', MPI_DOMAIN ); ?></label>
									</p>

									<textarea name="mpi_wplists" id="mpi_wplists" cols="40" rows="10"></textarea>

									<p class="description"><?php _e( 'Enter one name in one line.', MPI_DOMAIN ) ?></p>

									<div class="list-install-buttons">
										<input style="float: left;" class="button button-primary" type="submit" name="mpi_wpInstall" value="<?php _e( 'Install plugins', MPI_DOMAIN ); ?>" />
										<input style="float: left;"  class="button button-primary" type="submit" name="mpi_wpActivate" value="<?php _e( 'Install & Activate plugins', MPI_DOMAIN ); ?>" />
										<div class="mpi_clear"></div>
									</div>
								</div>
							</fieldset>
						</form>
						<?php
							if( isset( $_POST['mpi_wpInstall']) && trim( $_POST['mpi_wplists'])){
								$mp_installer->mpi_app_wpInstall( 'install' );
							}
							if( isset( $_POST['mpi_wpActivate']) && trim( $_POST['mpi_wplists'])){
								$mp_installer->mpi_app_wpInstall( 'activate' );
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<!-- //Install Plugins From Wordpress Site -->

		<!-- Install Plugins Directly From PC Zip Files -->
		<div id="poststuff" class="mpi-meta-box">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox">
					<button type="button" class="handlediv" aria-expanded="false" title="Click to toggle">
						<span class="toggle-indicator" aria-hidden="true"></span>
					</button>
					<h2 class="hndle ui-sortable-handle"><span><?php _e( 'Local Install', MPI_DOMAIN ); ?></span></h2>
					<div class="inside">
						<br/>
						<form onsubmit="return valid_zipfile( 'mpi_locFiles' );" name="form_uppcs" method="post" action="" enctype="multipart/form-data">
							<fieldset>
								<legend class="screen-reader-text"><?php _e( 'Local Install', MPI_DOMAIN ); ?></legend>
								<?php wp_nonce_field( $mp_installer->key); ?>
								<div>
									<input type="file" class="mpi_left" name="mpi_locFiles[]" id="mpi_locFiles" multiple="multiple" size="40" />
									<input class="button button-primary" type="submit" name="mpi_locInstall" value="<?php _e( 'Install & Activate plugins', MPI_DOMAIN ); ?>"  />
									<div class="mpi_clear"></div>
								</div>
								<p class="description"><?php _e( 'You can select multiple plugins.', MPI_DOMAIN ); ?></p>
							</fieldset>
						</form>
						<?php
							if ( isset( $_POST['mpi_locInstall']) && $_FILES['mpi_locFiles']['name'][0] != ""){
								$mp_installer->mpi_app_locInstall();
							}
						?>

					</div>
				</div>
			</div>
		</div>
		<!-- //Install Plugins Directly From PC Zip Files -->

		<!-- Install Plugins Using Exported File -->
		<div id="poststuff" class="mpi-meta-box">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox closed">
					<button type="button" class="handlediv" aria-expanded="false" title="Click to toggle">
						<span class="toggle-indicator" aria-hidden="true"></span>
					</button>
					<h2 class="hndle ui-sortable-handle"><span><?php _e( 'Import MPI', MPI_DOMAIN ); ?></span></h2>
					<div class="inside">
						<br/>
						<form onsubmit="return valid_extension();" name="form_expImp" method="post" action="" enctype="multipart/form-data">
							<fieldset>
								<legend class="screen-reader-text"><?php _e( 'Import MPI', MPI_DOMAIN ); ?></legend>
								<?php wp_nonce_field( $mp_installer->key); ?>
								<div>
									<input class="mpi_left" type="file" name="mpi_expfileUp" size="40" />
									<input class="button button-primary" type="submit" name="mpi_expfileImp" value="<?php _e( 'Install & Activate plugins', MPI_DOMAIN ); ?>" />
									<div class="mpi_clear"></div>
								</div>
							<fieldset>
						</form>
						<?php
							if ( isset( $_POST['mpi_expfileImp']) && $_FILES['mpi_expfileUp']['name'] != ""){
								$mp_installer->mpi_app_expFileUpload();
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<!-- //Install Plugins Using Exported File -->

		<!-- Download Exported Files -->
		<div id="poststuff" class="mpi-meta-box">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox closed">
					<button type="button" class="handlediv" aria-expanded="false" title="Click to toggle">
						<span class="toggle-indicator" aria-hidden="true"></span>
					</button>
					<h2 class="hndle ui-sortable-handle"><span><?php _e( 'Download Exported', MPI_DOMAIN ) ?></span></h2>
					<div class="inside">
						<?php $mp_installer->mpi_app_downloadFiles(); ?>
					</div>
				</div>
			</div>
		</div>
		<!-- //Download Exported Files -->

		<!-- Take Whole Plugins Backup -->
		<div id="poststuff" class="mpi-meta-box">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox closed">
					<button type="button" class="handlediv" aria-expanded="false" title="Click to toggle">
						<span class="toggle-indicator" aria-hidden="true"></span>
					</button>
					<h2 class="hndle ui-sortable-handle"><span><?php _e( 'Plugin Backups', MPI_DOMAIN ) ?></span></h2>
					<div class="inside">

						<div>
							<a class="mpi_plugbkup" href="<?php echo MPI_URL; ?>classes/class-plugins-backup.php"><?php _e( 'Click here to create plugins packup.', MPI_DOMAIN ) ?></a>
						</div>

						<?php $mp_installer->mpi_app_wholePluginsBkup(); ?>

					</div>
				</div>
			</div>
		</div>
		<!-- //Take Whole Plugins Backup -->

		<!-- Upload Downloaded Backup File To Install Plugins -->
		<div id="poststuff" class="mpi-meta-box">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox closed">
					<button type="button" class="handlediv" aria-expanded="false" title="Click to toggle">
						<span class="toggle-indicator" aria-hidden="true"></span>
					</button>
					<h2 class="hndle ui-sortable-handle"><span><?php _e( 'Upload Backup', MPI_DOMAIN ) ?></span></h2>
					<div class="inside">
						<form onsubmit="return valid_zipfile( 'mpi_upbackup' );" name="form_bkupl" method="post" action="" enctype="multipart/form-data">
							<fieldset>
								<legend class="screen-reader-text"><?php _e( 'Upload Backup', MPI_DOMAIN ) ?></legend>
								<?php wp_nonce_field( $mp_installer->key); ?>
								<div>
									<input type="file" class="mpi_left" name="mpi_upbackup" id="mpi_upbackup" size="40" />
									<input class="button button-primary" type="submit" name="mpi_upldpl" value="<?php _e( 'Install plugins', MPI_DOMAIN ); ?>" />
									<?php $mp_installer->mpi_getWP_maxupload_filesize(); ?>
									<div class="mpi_clear"></div>
								</div>
							<fieldset>
						</form>
						<?php
							if ( isset( $_POST['mpi_upldpl']) && $_FILES['mpi_upbackup']['name'] != ""){
								$mp_installer->mpi_app_pluginBkupFileUpload();
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<!-- //Upload Downloaded Backup File To Install Plugins -->
	</div>
</div>