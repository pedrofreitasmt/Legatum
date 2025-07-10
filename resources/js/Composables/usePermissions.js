import { usePage } from "@inertiajs/vue3";

export function usePermissions() {
    const can = (permission) => {
        const permissions = usePage().props.auth.can;

        return permissions ? permissions[permission] ?? false : false;
    };

    return { can };
}
