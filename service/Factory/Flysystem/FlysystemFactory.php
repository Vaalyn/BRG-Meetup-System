<?php
	namespace Service\Factory\Flysystem;

	use League\Flysystem\Filesystem;

	class FlysystemFactory {
		/**
		 * @param array $config
		 *
		 * @return \League\Flysystem\Filesystem
		 */
		public static function create(array $config): Filesystem {
			$adapter = new \ReflectionClass($config['adapter']);

	        $filesystem = new Filesystem(
				$adapter->newInstanceArgs($config['arguments']),
				$config['config']
			);

			return $filesystem;
		}
	}

?>
