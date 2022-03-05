<?php
if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

class Welcome extends Frontend_Controller
{
	protected $second;

	public function __construct()
	{
		parent::__construct();

		$this->load->model( 'Paginas_model', 'paginas' );
		$this->load->model( 'Posts_model', 'posts' );
		$this->load->model( 'Views_model', 'views' );
		$this->load->model( 'Infos_model', 'infos' );

		$this->second = $this->load->database( 'second', TRUE );
	}

	protected function get_infos() 
	{
		AbstractDeviceParser::setVersionTruncation( AbstractDeviceParser::VERSION_TRUNCATION_NONE );
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$dd = new DeviceDetector( $userAgent );
		$dd->parse();

		$dados = array();

		if ( ! $dd->isBot() ) 
		{
			$client = $dd->getClient();
			$os = $dd->getOs();

			$dados['navigator'] = $client['name'];
			$dados['navigator_version'] = $client['version'];
			$dados['os'] = $os['family'];
			$dados['os_arch'] = $os['platform'];
		}

		if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$userAgent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($userAgent,0,4))) 
		{
			$dados['is_mobile'] = TRUE;
		} 
		else 
		{
			$dados['is_mobile'] = FALSE;
		}

		$dados['hash'] = ci_rand(48);
		$dados['created_at'] = date( 'Y-m-d H:i:s' );

		return $dados;
	}

	public function info()
	{

		if ( $this->session->has_userdata( 'visited_user' ) ) {

		} else {
			$this->infos->insert( $this->get_infos() );
			$this->session->set_userdata( 'visited_user', TRUE );
		}

	}

	public function index()
	{

		$this->data['paginas'] = $this->paginas->get_all();

		if ( is_array( $this->data['paginas'] ) && sizeof( $this->data['paginas'] ) > 0 ) {	
			foreach ( $this->data['paginas'] as $page ) {
				echo anchor( 'welcome/pages/' . $page['slug'], $page['title'] ) . '<br>';
			}
		} else {
			echo '<em>Nenhuma página cadastrada.</em>';
		}

		echo '<h3>Posts</h3>';

		$this->data['posts'] = $this->posts->get_all();

		if ( is_array( $this->data['posts'] ) && sizeof( $this->data['posts'] ) > 0 ) {	
			foreach ( $this->data['posts'] as $post ) {
				echo anchor( 'welcome/posts/' . $post['slug'], $post['title'] ) . '<br>';
			}
		} else {
			echo '<em>Nenhum post cadastrado.</em>';
		}
	}	

	public function pages( $slug = '' ) {
		if ( ! empty( $slug ) ) {
			$slug = strip_tags( addslashes( trim( $slug ) ) );
			$page = $this->paginas->get_by( array( 'slug' => $slug ) );

			if ( $page != null ) {
				echo $page['title'];

				/* Views */
				$views = $this->views->get_by( array( 
					'post_type' => 'page', 
					'post_type_hash' => $page['hash'] 
				) );

				if ( $views != null ) {
					if ( $this->session->has_userdata( 'visited_posts_pages' ) )
					{
						if ( in_array( $views['id'], $this->session->userdata( 'visited_posts_pages' ) ) ) 
						{

						} 
						else 
						{
							$views_id = intval( $views['id'] );
							$views_count = intval( $views['views'] );
							$views_count = ( $views_count + 1 );

							$this->views->update( $views_id, array( 'views' => $views_count ) );

							$dados = $this->session->userdata('visited_posts_pages');
							$dados[] = $views['id'];

							$this->session->set_userdata( 'visited_posts_pages', $dados );
						}	

					}
					else 
					{
						$views_id = intval( $views['id'] );
						$views_count = intval( $views['views'] );
						$views_count = ( $views_count + 1 );
						
						$this->views->update( $views_id, array( 'views' => $views_count ) );
				
						$visited_posts_posts = array( $views['id'] );
						
						$this->session->set_userdata( 'visited_posts_pages', $visited_posts_posts );
					}
					

				} else {					

					$this->views->insert( array( 
						'post_type' => 'page', 
						'post_type_hash' => $page['hash'], 
						'views' => '1',
						'hash' => ci_rand(48),
						'created_at' => date( 'Y-m-d H:i:s' ) 
					) );

					$visited_posts_posts = array( $this->db->insert_id() );

					$this->session->set_userdata( 'visited_posts_pages', $visited_posts_posts );
				}
				/* Views */

			} else {
				redirect( base_url( 'welcome' ) );
			}
		} else {
			redirect( base_url( 'welcome' ) );
		}
	}

	public function posts( $slug = '' ) {
		if ( ! empty( $slug ) ) {
			$slug = strip_tags( addslashes( trim( $slug ) ) );
			$post = $this->posts->get_by( array( 'slug' => $slug ) );

			if ( $post != null ) {
				echo $post['title'];

				/* Views */
				$views = $this->views->get_by( array( 
					'post_type' => 'post', 
					'post_type_hash' => $post['hash'] 
				) );

				if ( $views != null ) {
					if ( $this->session->has_userdata( 'visited_posts' ) )
					{
						if ( in_array( $views['id'], $this->session->userdata( 'visited_posts' ) ) ) 
						{

						} 
						else 
						{
							$views_id = intval( $views['id'] );
							$views_count = intval( $views['views'] );
							$views_count = ( $views_count + 1 );

							$this->views->update( $views_id, array( 'views' => $views_count ) );

							$dados = $this->session->userdata('visited_posts');
							$dados[] = $views['id'];

							$this->session->set_userdata( 'visited_posts', $dados );
						}	

					}
					else 
					{
						$views_id = intval( $views['id'] );
						$views_count = intval( $views['views'] );
						$views_count = ( $views_count + 1 );
						
						$this->views->update( $views_id, array( 'views' => $views_count ) );
				
						$visited_posts_posts = array( $views['id'] );
						
						$this->session->set_userdata( 'visited_posts', $visited_posts_posts );
					}
					

				} else {					

					$this->views->insert( array( 
						'post_type' => 'post', 
						'post_type_hash' => $post['hash'], 
						'views' => '1',
						'hash' => ci_rand(48),
						'created_at' => date( 'Y-m-d H:i:s' ) 
					) );

					$visited_posts_posts = array( $this->db->insert_id() );

					$this->session->set_userdata( 'visited_posts', $visited_posts_posts );
				}
				/* Views */

			} else {
				redirect( base_url( 'welcome' ) );
			}
		} else {
			redirect( base_url( 'welcome' ) );
		}
	}
}