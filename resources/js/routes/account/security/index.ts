import { queryParams, type RouteDefinition, type RouteQueryOptions } from './../../../wayfinder'
/**
 * @see \App\Http\Controllers\Account\SecurityController::password
 * @see app/Http/Controllers/Account/SecurityController.php:21
 * @route '/account/security/password'
 */
export const password = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: password.url(options),
    method: 'put',
})

password.definition = {
    methods: ['put'],
    url: '/account/security/password',
} satisfies RouteDefinition<['put']>

/**
 * @see \App\Http\Controllers\Account\SecurityController::password
 * @see app/Http/Controllers/Account/SecurityController.php:21
 * @route '/account/security/password'
 */
password.url = (options?: RouteQueryOptions) => {
    return password.definition.url + queryParams(options)
}

/**
 * @see \App\Http\Controllers\Account\SecurityController::password
 * @see app/Http/Controllers/Account/SecurityController.php:21
 * @route '/account/security/password'
 */
password.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: password.url(options),
    method: 'put',
})

const security = {
    password: Object.assign(password, password),
}

export default security
