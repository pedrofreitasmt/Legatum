import { usePage } from '@inertiajs/vue3'

export function useSpatiePermissions() {
    const page = usePage()

    const hasPermission = (permission) => {
        return page.props.auth.permissions.includes(permission)
    }

    const hasAnyPermission = (permissions) => {
        return permissions.some(p => hasPermission(p))
    }

    const hasAllPermissions = (permissions) => {
        return permissions.every(p => hasPermission(p))
    }

    return { hasPermission, hasAnyPermission, hasAllPermissions }
}
