import { queryParams, type RouteDefinition, type RouteQueryOptions } from './../../../../../wayfinder'
/**
 * @see \App\Http\Controllers\Account\AccountController::edit
 * @see app/Http/Controllers/Account/AccountController.php:17
 * @route '/account'
 */
export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ['get', 'head'],
    url: '/account',
} satisfies RouteDefinition<['get', 'head']>

/**
 * @see \App\Http\Controllers\Account\AccountController::edit
 * @see app/Http/Controllers/Account/AccountController.php:17
 * @route '/account'
 */
edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

/**
 * @see \App\Http\Controllers\Account\AccountController::edit
 * @see app/Http/Controllers/Account/AccountController.php:17
 * @route '/account'
 */
edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

/**
 * @see \App\Http\Controllers\Account\AccountController::edit
 * @see app/Http/Controllers/Account/AccountController.php:17
 * @route '/account'
 */
edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

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

const AccountController = { edit, update, destroy }

export default AccountController
