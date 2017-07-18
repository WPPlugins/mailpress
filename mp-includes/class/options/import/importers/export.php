<?php
class MP_export extends MP_import_importer_
{
	var $id = 'csv_export';

	function dispatch( $step = 0 ) 
	{
		if ( isset( $_GET['step'] ) && !empty( $_GET['step'] ) ) $step = ( int ) $_GET['step'];

		$this->header();
		switch ( $step ) 
		{
			case 0 :
				$this->greet();
			break;
			case 1:
				$this->start_trace( $step );
					$export = $this->export();
				$this->end_trace( true );
				if ( $export )
				{
					$file = $this->url;
					$this->success( '<p>' . sprintf( __( "<b>File exported</b> : <i>%s</i>", 'MailPress' ), '<a href="' . $file . '">' . $file . '</a>' ) . '</p><p><strong>' . sprintf( __( "<b>Number of records</b> : <i>%s</i>", 'MailPress' ), $export ) . '</strong></p>' );
				}
				else 
					$this->error( '<p><strong>' . $this->file . '</strong></p>' );
			break;
		}
		$this->footer();
	}

// step 0

	function greet() 
	{
		$args = array( 'mp_import' => $this->id, 'step' => 1 );
?>
<div>
	<p>
<?php		_e( 'Howdy! Ready to export the emails ... into a file.', 'MailPress' ); ?>
		<br />
	</p>
	<form id="export" method="post" action="<?php echo esc_url( add_query_arg( $args, MailPress_import ) ); ?>">
		<p>
			<br /><br /><br />
		</p>
		<p class="submit">
			<input type="submit" class="button" value="<?php echo esc_attr( __( 'Export', 'MailPress' ) ); ?>" />
		</p>
	</form>
</div>
<?php
	}

// step 1

	function export() 
	{
		$this->message_report( " EXPORTING  !" );

		global $wpdb;

		$fields = array( 'id', 'email', 'name', 'status', 'created', 'created_IP', 'created_agent', 'created_user_id', 'created_country', 'created_US_state', 'laststatus', 'laststatus_IP', 'laststatus_agent', 'laststatus_user_id' );
		$users = $wpdb->get_results( "SELECT DISTINCT " . join( ', ', $fields ) . " FROM $wpdb->mp_users ; ", ARRAY_A );

		if ( empty( $users ) )
		{
			$this->message_report( ' **WARNING* ! list is empty !' );
			return false;
		}

		$this->file = 'csv_export_' . date( 'Ymd_Hi' ) . '.csv';

		require_once 'parsecsv/parsecsv.lib.php';
		$csv = new parseCSV();
		$r = file_put_contents( MP_ABSPATH . 'tmp/' . $this->file, $csv->unparse( $users, $fields ) );

		if ( !$r )
		{
			$this->message_report( ' ***ERROR** ! Unable to write file' );
			return false;
		}

		$file['name'] = $this->file;
		$file['tmp_name'] = MP_ABSPATH . 'tmp/' . $this->file;
		$file['type'] = 'csv';

		$this->url = $this->insert_attachment( $file );

		if ( !$this->url ) $this->url = site_url() . '/' . MP_PATH . 'tmp/' . $this->file;

		$this->message_report( '   SUCCESS  ! file available at ' . $this->url );
		return count( $users );
	}
}
new MP_export( __( 'Export your MP users in a <strong>csv</strong> file.', 'MailPress' ), __( 'Export', 'MailPress' ) );