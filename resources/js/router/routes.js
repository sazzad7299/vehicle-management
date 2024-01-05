import pharmacy from './pharmacy';
let routes = [
    {
        path: '/login',
        name: 'login',
        component: () => import('../components/auth/login.vue'),
        meta: {
            title: 'Login',
            isGuest: true
        }
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../components/auth/register.vue'),
        meta: {
            title: 'Register',
            isGuest: true
        }
    },
    {
        path: '/buy-plan',
        name: 'registersubscribe',
        component: () => import('../components/auth/registersubscribe.vue'),
        meta: {
            title: 'Buy Plan',
            requiresAuth: true,
            ignore:true,
        }
    },
    {
        path: '/forgot-password',
        name: 'forgotPassword',
        component: () => import('../components/auth/forgot-password.vue'),
        meta: {
            title: 'Forgot Password',
            isGuest: true
        }
    },
    {
        path: '/reset-password',
        name: 'resetPassword',
        component: () => import('../components/auth/reset-password.vue'),
        meta: {
            title: 'Reset Password',
            isGuest: true
        }
    },
    {
        path: '/user-verification',
        name: 'verifyotp',
        component: () => import('../components/auth/verifyotp.vue'),
        meta: {
            title: 'Verify OTP',
            isGuest: true
        }
    },
    {
        path: '/terms-and-conditions',
        name: 'terms-and-conditions',
        component: () => import('../pages/terms-and-conditions.vue'),
        meta: {
            title: 'Terms and Conditions',
            isGuest: true
        }
    },
    // {
    //     path: '/',
    //     name: 'welcome',
    //     component: () => import('../pages/terms-and-conditions.vue'),
    //     meta: {
    //         title: 'Welcome to Pharmacy',
    //         isGuest: true
    //     }
    // },
    {
        path: '/',
        name: 'app',
        // redirect: {name: 'dashboard'},
        component: () => import('../pages/app.vue'),
        meta: {
            title: 'AppLayout',
            requiresAuth: true
        },
        children: [
            {
                path: '/dashboard',
                name: 'dashboard',
                component: () => import('../components/dashboard/dashboard.vue'),
                meta: {
                    title: 'Dashboard',
                    requiresAuth: true
                }
            },
            {
                path: '/user/profile',
                name: 'profile',
                component: () => import('../components/profile/edit.vue'),
                meta: {
                    title: 'Account Settings',
                    requiresAuth: true,
                    ignore: true
                }
            },
            {
                path: '/user/activity-logs',
                name: 'user.logs',
                component: () => import('../components/user/activitylog.vue'),
                meta: {
                    title: 'Activity Logs',
                    requiresAuth: true,
                    ignore: true
                }
            },

            {
                path: '/roles',
                name: 'role.index',
                component: () => import('../components/rbac/role/index.vue'),
                meta: {
                    title: 'Roles',
                    requiresAuth: true
                }
            },
            {
                path: '/roles/create',
                name: 'role.create',
                component: () => import('../components/rbac/role/create.vue'),
                meta: {
                    title: 'Create Role',
                    requiresAuth: true
                }
            },
            {
                path: '/roles/:id/edit',
                name: 'role.edit',
                component: () => import('../components/rbac/role/edit.vue'),
                meta: {
                    title: 'Edit Role',
                    requiresAuth: true
                }
            },
            {
                path: '/roles/:id/assign-permission',
                name: 'role.assign-permission',
                component: () => import('../components/rbac/role/assign-permission.vue'),
                meta: {
                    title: 'Assign Role Permission',
                    requiresAuth: true
                }
            },
            {
                path: '/permission',
                name: 'permission.index',
                component: () => import('../components/rbac/permission/index.vue'),
                meta: {
                    title: 'Permissions',
                    requiresAuth: true
                }
            },
            {
                path: '/permission/create',
                name: 'permission.create',
                component: () => import('../components/rbac/permission/create.vue'),
                meta: {
                    title: 'Create Permissions',
                    requiresAuth: true
                }
            },
            {
                path: '/permission/:id/edit',
                name: 'permission.edit',
                component: () => import('../components/rbac/permission/edit.vue'),
                meta: {
                    title: 'Edit Permissions',
                    requiresAuth: true
                }
            },
            {
                path: '/user-access',
                name: 'user-access.index',
                component: () => import('../components/rbac/user-access/index.vue'),
                meta: {
                    title: 'User Access',
                    requiresAuth: true
                }
            },
            {
                path: '/user-access/create',
                name: 'user-access.create',
                component: () => import('../components/rbac/user-access/create.vue'),
                meta: {
                    title: 'Grant User Access',
                    requiresAuth: true
                }
            },
            {
                path: '/pharmacy',
                name: 'pharmacy.index',
                component: () => import('../components/pharmacy/index.vue'),
                meta: {
                    title: 'Pharmacy List',
                    requiresAuth: true
                }
            },
            {
                path: '/pharmacy/create',
                name: 'pharmacy.create',
                component: () => import('../components/pharmacy/create.vue'),
                meta: {
                    title: 'Create Pharmacy',
                    requiresAuth: true
                }
            },
            {
                path: '/pharmacy/:id/edit',
                name: 'pharmacy.edit',
                component: () => import('../components/pharmacy/edit.vue'),
                meta: {
                    title: 'Edit Pharmacy',
                    requiresAuth: true
                }
            },
            {
                path: '/user',
                name: 'user.index',
                component: () => import('../components/user/index.vue'),
                meta: {
                    title: 'User List',
                    requiresAuth: true
                }
            },
            {
                path: '/user/create',
                name: 'user.create',
                component: () => import('../components/user/create.vue'),
                meta: {
                    title: 'Create User',
                    requiresAuth: true
                }
            },
            {
                path: '/user/:id/edit',
                name: 'user.edit',
                component: () => import('../components/user/edit.vue'),
                meta: {
                    title: 'Edit User',
                    requiresAuth: true
                }
            },
            {
                path: '/plan',
                name: 'plan.index',
                component: () => import('../components/plan/index.vue'),
                meta: {
                    title: 'Plan List',
                    requiresAuth: true
                }
            },
            {
                path: '/plan/create',
                name: 'plan.create',
                component: () => import('../components/plan/create.vue'),
                meta: {
                    title: 'Create Plan',
                    requiresAuth: true
                }
            },
            {
                path: '/plan/:id/edit',
                name: 'plan.edit',
                component: () => import('../components/plan/edit.vue'),
                meta: {
                    title: 'Edit Plan',
                    requiresAuth: true
                }
            },
            //subscriptions
            {
                path: '/subcriptions',
                name: 'subscription.index',
                component: () => import('../components/subscription/index.vue'),
                meta: {
                    title: 'Subscription List',
                    requiresAuth: true
                }
            },
            /////
            {
                path: '/payments',
                name: 'payment.index',
                component: () => import('../components/payment-method/index.vue'),
                meta: {
                    title: 'Payments List',
                    requiresAuth: true
                }
            },
            {
                path: '/payments/create',
                name: 'payment.create',
                component: () => import('../components/payment-method/create.vue'),
                meta: {
                    title: 'Create Payments',
                    requiresAuth: true
                }
            },
            {
                path: '/payments/:id/edit',
                name: 'payment.edit',
                component: () => import('../components/payment-method/edit.vue'),
                meta: {
                    title: 'Payments',
                    requiresAuth: true
                }
            },
            ...pharmacy
        ]
    },
];
export default routes;
