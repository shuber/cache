# Cache

A simple php caching library with swappable backends


## Usage

	$cache = new Cache('Filesystem', '/path/to/your/cache');
	
	$cache->write('users', array('bob', 'joe', 'tim'));
	print_r($cache->read('users'));
	
	// If a cache exists then it returns it, otherwise it executes the block and caches the result
	echo $cache->fetch('admins', function() {
		return Admin::all();
	});