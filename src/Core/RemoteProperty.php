<?php


namespace WOF\Core;

defined( 'ABSPATH' ) || exit;

/**
 * An abstract base class to encapsulate properties that exists on remote resources such as databases and APIs.
 * When used, it saves the
 *
 * @package WOF\Core
 */
abstract class RemoteProperty {

    /**
     * @var mixed The cached value of the remote property.
     */
    protected $value;

    /**
     * @var boolean The flag that invalidates the cache.
     */
    protected bool $invalidated = false;


    /**
     * Returns the cached value of the remote property or retrieves a fresh copy if the value is invalidated.
     *
     * @return mixed the cached value of the remote property
     */
    public function getValue () {
        if (!isset($this->value) || $this->invalidated) {
            $this->refresh();
        }
        return $this->value;
    }

    /**
     * @return bool Returns true if the cached value is invalidated and needs to be refreshed.
     */
    public function isInvalidated () : bool{
        return $this->invalidated;
    }

    /**
     * Invalidates the cached value so the caller knows it must refresh the value before retrieving.
     */
    public function invalidate () {
        $this->invalidated = true;
    }

    /**
     * Refresh the value from the remote resource.
     */
    protected function refresh () {
        $this->invalidated = false;
    }
}
