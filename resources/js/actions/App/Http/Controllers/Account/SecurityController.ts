import { queryParams, type RouteDefinition, type RouteQueryOptions } from './../../../../../wayfinder'
/**
 * @see \App\Http\Controllers\Account\SecurityController::edit
 * @see app/Http/Controllers/Account/SecurityController.php:16
 * @route '/account/security'
 */
export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ['get', 'head'],
    url: '/account/security',
} satisfies RouteDefinition<['get', 'head']>

/**
 * @see \App\Http\Controllers\Account\SecurityController::edit
 * @see app/Http/Controllers/Account/SecurityController.php:16
 * @route '/account/security'
 */
edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

/**
 * @see \App\Http\Controllers\Account\SecurityController::edit
 * @see app/Http/Controllers/Account/SecurityController.php:16
 * @route '/account/security'
 */
edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

/**
 * @see \App\Http\Controllers\Account\SecurityController::edit
 * @see app/Http/Controllers/Account/SecurityController.php:16
 * @route '/account/security'
 */
edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

/**
 * @see \App\Http\Controllers\Account\SecurityController::updatePassword
 * @see app/Http/Controllers/Account/SecurityController.php:21
 * @route '/account/security/password'
 */
export const updatePassword = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatePassword.url(options),
    method: 'put',
})

updatePassword.definition = {
    methods: ['put'],
    url: '/account/security/password',
} satisfies RouteDefinition<['put']>

/**
 * @see \App\Http\Controllers\Account\SecurityController::updatePassword
 * @see app/Http/Controllers/Account/SecurityController.php:21
 * @route '/account/security/password'
 */
updatePassword.url = (options?: RouteQueryOptions) => {
    return updatePassword.definition.url + queryParams(options)
}

/**
 * @see \App\Http\Controllers\Account\SecurityController::updatePassword
 * @see app/Http/Controllers/Account/SecurityController.php:21
 * @route '/account/security/password'
 */
updatePassword.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatePassword.url(options),
    method: 'put',
})

const SecurityController = { edit, updatePassword }

export default SecurityController
