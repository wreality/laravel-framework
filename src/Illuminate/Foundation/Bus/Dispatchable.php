<?php

namespace Illuminate\Foundation\Bus;

use Illuminate\Contracts\Bus\Dispatcher;

trait Dispatchable
{
    /**
     * Dispatch the job with the given arguments.
     *
     * @return \Illuminate\Foundation\Bus\PendingDispatch
     */
    public static function dispatch()
    {
        return new PendingDispatch(new static(...func_get_args()));
    }

    /**
     * Dispatch the job with the given arguments if the given truth test passes.
     *
     * @param  bool  $boolean
     * @return \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Support\Fluent
     */
    public static function dispatchIf($boolean, ...$arguments)
    {
        return $boolean
            ? new PendingDispatch(new static(...$arguments))
            : new Fluent;
    }

    /**
     * Dispatch the job with the given arguments unless the given truth test passes.
     *
     * @param  bool  $boolean
     * @return \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Support\Fluent
     */
    public static function dispatchUnless($boolean, ...$arguments)
    {
        return ! $boolean
            ? new PendingDispatch(new static(...$arguments))
            : new Fluent;
    }

    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @return mixed
     */
    public static function dispatchNow()
    {
        return app(Dispatcher::class)->dispatchNow(new static(...func_get_args()));
    }

    /**
     * Set the jobs that should run if this job is successful.
     *
     * @param  array  $chain
     * @return \Illuminate\Foundation\Bus\PendingChain
     */
    public static function withChain($chain)
    {
        return new PendingChain(static::class, $chain);
    }
}
