<?php
namespace App\Models;

use App\Traits\ModelHelperTrait;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Model extends EloquentModel
{
    use SoftDeletes, ModelHelperTrait, RevisionableTrait;

    const SLUG_SEPERATOR = '_';

    protected $revisionEnabled = true;
    protected $revisionCreationsEnabled = true;

    protected $cache = [];

    protected function cacheGet($key, $default = null)
    {
        return array_get($this->cache, $key, $default);
    }

    protected function cacheSet($key, $value)
    {
        $this->cache[$key] = $value;
    }

    protected function cacheRemember($key, \Closure $callback)
    {
        if (!is_null($value = $this->cacheGet($key))) {
            return $value;
        }
        $this->cacheSet($key, $value = $callback());
        return $value;
    }

    public function getRevisions($limit = 100)
    {
        return $this->revisionHistory()->orderBy('created_at', 'desc')->limit($limit)->get();
    }
}
