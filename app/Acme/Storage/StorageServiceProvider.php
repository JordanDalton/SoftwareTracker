<?php namespace Acme\Storage;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider {

    /** 
     * Define which models will need interface to repository bindings.
     * 
     * @var array
     */
    protected $models_to_bind = [
        'Department',
        'Machine',
        'Program',
        'Publisher'
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        foreach( $this->models_to_bind as $model_to_bind )
        {
            $this->app->bind(
                'Acme\Storage\Interfaces\\'   . $model_to_bind  . 'RepositoryInterface', 
                'Acme\Storage\Repositories\\' . $model_to_bind  . 'Repository'
            );
        }
    }
}