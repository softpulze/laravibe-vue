import { queryParams, type RouteDefinition, type RouteQueryOptions } from './../../wayfinder'
import security176da1 from './security'
/**
 * @see \App\Http\Controllers\Account\AccountController::update
 * @see app/Http/Controllers/Account/AccountController.php:31
 * @route '/account'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

update.definition = {
    methods: ['patch'],
    url: '/account',
} satisfies RouteDefinition<['patch']>

/**
 * @see \App\Http\Controllers\Account\AccountController::update
 * @see app/Http/Controllers/Account/AccountController.php:31
 * @route '/account'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
 * @see \App\Http\Controllers\Account\AccountController::update
 * @see app/Http/Controllers/Account/AccountController.php:31
 * @route '/account'
 */
update.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

/**
 * @see \App\Http\Controllers\Account\AccountController::destroy
 * @see app/Http/Controllers/Account/AccountController.php:50
 * @route '/account'
 */
export const destroy = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(options),
    method: 'delete',
})

destroy.definition = {
    methods: ['delete'],
    url: '/account',
} satisfies RouteDefinition<['delete']>

/**
 * @see \App\Http\Controllers\Account\AccountController::destroy
 * @see app/Http/Controllers/Account/AccountController.php:50
 * @route '/account'
 */
destroy.url = (options?: RouteQueryOptions) => {
    return destroy.definition.url + queryParams(options)
}

/**
 * @see \App\Http\Controllers\Account\AccountController::destroy
 * @see app/Http/Controllers/Account/AccountController.php:50
 * @route '/account'
 */
destroy.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(options),
    method: 'delete',
})

/**
 * @see \App\Http\Controllers\Account\SecurityController::security
 * @see app/Http/Controllers/Account/SecurityController.php:16
 * @route '/account/security'
 */
export const security = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: security.url(options),
    method: 'get',
})

security.definition = {
    methods: ['get', 'head'],
    url: '/account/security',
} satisfies RouteDefinition<['get', 'head']>

/**
 * @see \App\Http\Controllers\Account\SecurityController::security
 * @see app/Http/Controllers/Account/SecurityController.php:16
 * @route '/account/security'
 */
security.url = (options?: RouteQueryOptions) => {
    return security.definition.url + queryParams(options)
}

/**
 * @see \App\Http\Controllers\Account\SecurityController::security
 * @see app/Http/Controllers/Account/SecurityController.php:16
 * @route '/account/security'
 */
security.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: security.url(options),
    method: 'get',
})

/**
 * @see \App\Http\Controllers\Account\SecurityController::security
 * @see app/Http/Controllers/Account/SecurityController.php:16
 * @route '/account/security'
 */
security.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: security.url(options),
    method: 'head',
})

/**
 * @see routes/account.php:21
 * @route '/account/appearance'
 */
export const appearance = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: appearance.url(options),
    method: 'get',
})

appearance.definition = {
    methods: ['get', 'head'],
    url: '/account/appearance',
} satisfies RouteDefinition<['get', 'head']>

/**
 * @see routes/account.php:21
 * @route '/account/appearance'
 */
appearance.url = (options?: RouteQueryOptions) => {
    return appearance.definition.url + queryParams(options)
}

/**
 * @see routes/account.php:21
 * @route '/account/appearance'
 */
appearance.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: appearance.url(options),
    method: 'get',
})

/**
 * @see routes/account.php:21
 * @route '/account/appearance'
 */
appearance.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: appearance.url(options),
    method: 'head',
})

const account = {
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
    security: Object.assign(security, security176da1),
    appearance: Object.assign(appearance, appearance),
}

export default account
