<?php
/**
 * Plugin backup class
 *
 * @package MP_Installer
 * @subpackage Includes
 * @since 1.0.0
 */

namespace MP_Installer\Includes;

class Plugins_Backup {

	private function mpi_recurse_zip( $src, &$zip, $path) {

		$dir = opendir( $src );

		while ( false !== ( $file = readdir( $dir ) ) ) {

			if ( ( $file != '.' ) && ( $file != '..' ) ) {

				if ( is_dir( $src . '/' . $file ) ) {
					$this->mpi_recurse_zip( $src . '/' . $file, $zip, $path );
				} else {
					$zip->addFile( $src . '/' . $file, substr( $src . '/' . $file, $path ) );
				}
			}
		}

		closedir( $dir );

		header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
	}

	public function mpi_compress( $src, $dst='' ) {

		if ( substr( $src, -1 ) === '/' ) {
			$src=substr( $src, 0, -1 );
		}

		if ( substr( $dst, -1 ) === '/' ) {
			$dst=substr( $dst, 0, -1 );
		}

		$path     = strlen(dirname( $src ) . '/' );
		$filename = 'pluginsbackup_' . time() . '.zip';
		$dst      = empty( $dst ) ? $filename : $dst . '/' . $filename;
		@unlink( $dst );

		$zip = new \ZipArchive;
		$res = $zip->open( $dst, \ZipArchive::CREATE );

		if ( true !== $res ) {

				e_( 'Error: Unable to create zip file', MPI_DOMAIN );

				exit;
		}

		if ( is_file( $src ) ) {
			$zip->addFile( substr( $src, $path ) );

		} else {

			if ( ! is_dir( $src ) ) {

					$zip->close();
					@unlink( $dst );

					e_( 'Error: File not found', MPI_DOMAIN );

					exit;
				}

			$this->mpi_recurse_zip( $src, $zip, $path );
		}

		$zip->close();

		return $dst;
	}

}

$mpi_obj = new Plugins_Backup();
$mpi_src = '../../../plugins/';
$mpi_dst = '../../../uploads/mp-installer-logs';
$mpi_obj->mpi_compress( $mpi_src,$mpi_dst );
