# Cache

A simple php caching library with swappable backends


## Usage

	$cache = new Cache('Filesystem', '/path/to/your/cache');
	
	$cache->write('users', array('bob', 'joe', 'tim'));
	print_r($cache->read('users'));
	$cache->delete('users');
	
	// If a fresh cache exists then it returns it, otherwise it executes the block (passing the current cache's modified time if there is one) and caches the result
	print_r($cache->fetch('admins', function($modified_at) {
	    return Admin::all();
	}));