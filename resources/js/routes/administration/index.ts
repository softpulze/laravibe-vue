import { queryParams, type RouteDefinition, type RouteQueryOptions } from './../../wayfinder'
/**
 * @see routes/web.php:15
 * @route '/administration/dashboard'
 */
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ['get', 'head'],
    url: '/administration/dashboard',
} satisfies RouteDefinition<['get', 'head']>

/**
 * @see routes/web.php:15
 * @route '/administration/dashboard'
 */
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
 * @see routes/web.php:15
 * @route '/administration/dashboard'
 */
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
 * @see routes/web.php:15
 * @route '/administration/dashboard'
 */
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

const administration = {
    dashboard: Object.assign(dashboard, dashboard),
}

export default administration
