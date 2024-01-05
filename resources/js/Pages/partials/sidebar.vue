<template>
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
            <router-link :to="{ name: 'dashboard' }" class="app-brand-link">
                <span class="app-brand-text demo menu-text fw-bolder ms-2  text-capitalize">MyPharmacity</span>
            </router-link>
            <a @click="sidebarToggle" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>
        <div class="menu-inner-shadow"></div>
        <ul class="menu-inner py-1">
            <li v-if="hasPermission('dashboard')" class="menu-item" :class="$route.name === 'dashboard' ? 'active' : ''">
                <router-link :to="{ name: 'dashboard' }" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    Dashboard
                </router-link>
            </li>
            <li class="menu-item"
                v-if="hasPermission('user') || hasPermission('user.index') || hasPermission('user.create') || hasPermission('user.edit') || hasPermission('user.delete')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Invoice">Users</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('user.create')" class="menu-item"
                        :class="$route.name === 'user.create' ? 'active' : ''">
                        <router-link :to="{ name: 'user.create' }" class="menu-link"> <i
                                class="menu-icon tf-icons bx bx-add-to-queue"></i>User Add</router-link>
                    </li>
                    <li v-if="hasPermission('user.index') || hasPermission('user.edit') || hasPermission('user.delete')"
                        class="menu-item" :class="$route.name === 'user.index' ? 'active' : ''">
                        <router-link :to="{ name: 'user.index' }" class="menu-link"> <i
                                class="menu-icon tf-icons bx bx-list-ol"></i>User List</router-link>
                    </li>
                    <li v-if="hasPermission('role.index')" class="menu-item"
                        :class="$route.name === 'role.index' ? 'active' : ''">
                        <router-link :to="{ name: 'role.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-check-shield"></i> Role
                        </router-link>
                    </li>

                </ul>
            </li>
            <li class="menu-item"
                v-if="hasPermission('employee') || hasPermission('employee.index') || hasPermission('employee.create') || hasPermission('employee.edit') || hasPermission('employee.delete') || hasPermission('salary.create') || hasPermission('salary.index')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Invoice">Employees</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('employee.create')" class="menu-item"
                        :class="$route.name === 'employee.create' ? 'active' : ''">
                        <router-link :to="{ name: 'employee.create' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-add-to-queue"></i>
                            Add Employees
                        </router-link>
                    </li>
                    <li v-if="hasPermission('employee.index') || hasPermission('employee.edit') || hasPermission('employee.delete')"
                        class="menu-item" :class="$route.name === 'employee.index' ? 'active' : ''">
                        <router-link :to="{ name: 'employee.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Employees List
                        </router-link>
                    </li>
                    <li v-if="hasPermission('salary.create') || hasPermission('salary.index')" class="menu-item"
                        :class="$route.name === 'salary.index' ? 'active' : ''">
                        <router-link :to="{ name: 'salary.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-money"></i>
                            Employees Salary
                        </router-link>
                    </li>
                </ul>
            </li>
            <!-- <li class="menu-item"
                v-if="hasPermission('salary') || hasPermission('salary.index') || hasPermission('salary.create') || hasPermission('salary.advancelist') || hasPermission('salary.advancepay')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-money"></i>
                    <div data-i18n="Invoice">Salary</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('salary.create') || hasPermission('salary.index')" class="menu-item"
                        :class="$route.name === 'salary.index' ? 'active' : ''">
                        <router-link :to="{ name: 'salary.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Salary
                        </router-link>
                    </li>
                    <li v-if="hasPermission('salary.advancelist') || hasPermission('salary.advancepay')"
                        class="menu-item" :class="$route.name === 'salary.advancelist' ? 'active' : ''">
                        <router-link :to="{ name: 'salary.advancelist' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Advance Salary
                        </router-link>
                    </li>
                </ul>
            </li> -->
            <li class="menu-item"
                v-if="hasPermission('sale') || hasPermission('sale.index') || hasPermission('sale.create') | hasPermission('sale.returnlist')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-trending-up"></i>
                    <div data-i18n="Invoice">Sales</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('sale.create')" class="menu-item"
                        :class="$route.name === 'sale.create' ? 'active' : ''">
                        <router-link :to="{ name: 'sale.create' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-add-to-queue"></i>
                            New Sale
                        </router-link>
                    </li>
                    <li v-if="hasPermission('sale.index')" class="menu-item"
                        :class="$route.name === 'sale.index' ? 'active' : ''">
                        <router-link :to="{ name: 'sale.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Sale List
                        </router-link>
                    </li>
                    <li v-if="hasPermission('sale.returnlist')" class="menu-item"
                        :class="$route.name === 'sale.returnlist' ? 'active' : ''">
                        <router-link :to="{ name: 'sale.returnlist' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Sale Return
                        </router-link>
                    </li>
                    <li v-if="hasPermission('sale.exchange')" class="menu-item"
                        :class="$route.name === 'sale.exchange' ? 'active' : ''">
                        <router-link :to="{ name: 'sale.exchange' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Exchange
                        </router-link>
                    </li>
                    <li v-if="hasPermission('sale.dueCollect')" class="menu-item"
                        :class="$route.name === 'sale.dueCollect' ? 'active' : ''">
                        <router-link :to="{ name: 'sale.dueCollect' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Due Collect
                        </router-link>
                    </li>
                </ul>
            </li>
            <li v-if="hasPermission('medicine') || hasPermission('medicine.index') || hasPermission('medicine.create') || hasPermission('medicine.edit') || hasPermission('medicine.stock') || hasPermission('leaf.index') || hasPermission('leaf.create') || hasPermission('leaf.view') || hasPermission('shelf.index') || hasPermission('shelf.create')"
                class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-capsule"></i>
                    <div data-i18n="Invoice">Medicine</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('medicine.stock')" class="menu-item"
                        :class="$route.name === 'medicine.stock' ? 'active' : ''">
                        <router-link :to="{ name: 'medicine.stock' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Stocks
                        </router-link>
                    </li>
                    <li v-if="hasPermission('medicine.create')" class="menu-item"
                        :class="$route.name === 'medicine.create' ? 'active' : ''">
                        <router-link :to="{ name: 'medicine.create' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-add-to-queue"></i>
                            Add Medicine
                        </router-link>
                    </li>
                    <li v-if="hasPermission('medicine.index')" class="menu-item"
                        :class="$route.name === 'medicine.index' ? 'active' : ''">
                        <router-link :to="{ name: 'medicine.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Medicine List
                        </router-link>
                    </li>
                    <li v-if="hasPermission('category.index') || hasPermission('category.list') || hasPermission('category.create') || hasPermission('category.view')"
                        class="menu-item" :class="$route.name === 'category.index' ? 'active' : ''">
                        <router-link :to="{ name: 'category.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Categories
                        </router-link>
                    </li>
                    <li v-if="hasPermission('unit.index') || hasPermission('unit.list') || hasPermission('unit.create') || hasPermission('unit.view')"
                        class="menu-item" :class="$route.name === 'unit.index' ? 'active' : ''">
                        <router-link :to="{ name: 'unit.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Units
                        </router-link>
                    </li>
                    <li v-if="hasPermission('leaf.index') || hasPermission('leaf.list') || hasPermission('leaf.create') || hasPermission('leaf.view')"
                        class="menu-item" :class="$route.name === 'leaf.index' ? 'active' : ''">
                        <router-link :to="{ name: 'leaf.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Leaf
                        </router-link>
                    </li>
                    <li v-if="hasPermission('type.index') || hasPermission('type.list') || hasPermission('type.create') || hasPermission('type.view')"
                        class="menu-item" :class="$route.name === 'type.index' ? 'active' : ''">
                        <router-link :to="{ name: 'type.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Types
                        </router-link>
                    </li>
                    <li v-if="hasPermission('shelf.index') || hasPermission('shelf.list') || hasPermission('shelf.create') || hasPermission('shelf.view')"
                        class="menu-item" :class="$route.name === 'shelf.index' ? 'active' : ''">
                        <router-link :to="{ name: 'shelf.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Shelf
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="menu-item"
                v-if="hasPermission('purchase') || hasPermission('purchase.index') || hasPermission('purchase.create') | hasPermission('purchase.returnlist')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-shopping-bags"></i>
                    <div data-i18n="Invoice">Purchase</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('purchase.create')" class="menu-item"
                        :class="$route.name === 'purchase.create' ? 'active' : ''">
                        <router-link :to="{ name: 'purchase.create' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-add-to-queue"></i>
                            Add Purchase
                        </router-link>
                    </li>
                    <li v-if="hasPermission('purchase.index')" class="menu-item"
                        :class="$route.name === 'purchase.index' ? 'active' : ''">
                        <router-link :to="{ name: 'purchase.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Purchase List
                        </router-link>
                    </li>
                    <li v-if="hasPermission('purchase.returnlist')" class="menu-item"
                        :class="$route.name === 'purchase.returnlist' ? 'active' : ''">
                        <router-link :to="{ name: 'purchase.returnlist' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Purchase Return
                        </router-link>
                    </li>
                    <li v-if="hasPermission('purchase.dueCollect')" class="menu-item"
                        :class="$route.name === 'purchase.dueCollect' ? 'active' : ''">
                        <router-link :to="{ name: 'purchase.dueCollect' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Due Collect
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="menu-item"
                v-if="hasPermission('supplier') || hasPermission('supplier.index') || hasPermission('supplier.create') || hasPermission('supplier.view') || hasPermission('supplier.view')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-user-account"></i>
                    <div data-i18n="Invoice">Suppliers</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('supplier.create')" class="menu-item"
                        :class="$route.name === 'supplier.create' ? 'active' : ''">
                        <router-link :to="{ name: 'supplier.create' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-add-to-queue"></i>
                            Add Supplier
                        </router-link>
                    </li>
                    <li v-if="hasPermission('supplier.index') || hasPermission('supplier.view')" class="menu-item"
                        :class="$route.name === 'supplier.index' ? 'active' : ''">
                        <router-link :to="{ name: 'supplier.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Supplier List
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="menu-item"
                v-if="hasPermission('manufacturer') || hasPermission('manufacturer.index') || hasPermission('manufacturer.create') || hasPermission('manufacturer.edit') || hasPermission('manufacturer.delete') || hasPermission('manufacturer.view')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-sitemap"></i>
                    <div data-i18n="Invoice">Manufacturesrs</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('manufacturer.create')" class="menu-item"
                        :class="$route.name === 'manufacturer.create' ? 'active' : ''">
                        <router-link :to="{ name: 'manufacturer.create' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-add-to-queue"></i>
                            Add Manufacturesr
                        </router-link>
                    </li>
                    <li v-if="hasPermission('manufacturer.index') || hasPermission('manufacturer.edit') || hasPermission('manufacturer.delete') || hasPermission('manufacturer.view')"
                        class="menu-item" :class="$route.name === 'manufacturer.index' ? 'active' : ''">
                        <router-link :to="{ name: 'manufacturer.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Manufacturesrs List
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="menu-item"
                v-if="hasPermission('customer') || hasPermission('customer.index') || hasPermission('customer.create') || hasPermission('customer.edit') || hasPermission('customer.delete')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Invoice">Customers</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('customer.create')" class="menu-item"
                        :class="$route.name === 'customer.create' ? 'active' : ''">
                        <router-link :to="{ name: 'customer.create' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-add-to-queue"></i>
                            Add Customers
                        </router-link>
                    </li>
                    <li v-if="hasPermission('customer.index') || hasPermission('customer.edit') || hasPermission('customer.delete')"
                        class="menu-item" :class="$route.name === 'customer.index' ? 'active' : ''">
                        <router-link :to="{ name: 'customer.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Customers List
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="menu-item"
                v-if="hasPermission('account') || hasPermission('balance') || hasPermission('balance.index') || hasPermission('balance.create') || hasPermission('balance.edit') || hasPermission('balance.delete') || hasPermission('cost') || hasPermission('payment-method')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-badge-dollar"></i>
                    <div data-i18n="Invoice">Accounts</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('balance') || hasPermission('balance.index') || hasPermission('balance.create') || hasPermission('balance.edit') || hasPermission('balance.delete')"
                        class="menu-item" :class="$route.name === 'balance.index' ? 'active' : ''">
                        <router-link :to="{ name: 'balance.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Balance
                        </router-link>
                    </li>
                    <li v-if="hasPermission('cost') || hasPermission('cost.index') || hasPermission('cost.create') || hasPermission('cost.edit') || hasPermission('cost.delete')"
                        class="menu-item" :class="$route.name === 'cost.index' ? 'active' : ''">
                        <router-link :to="{ name: 'cost.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Cost
                        </router-link>
                    </li>
                    <li v-if="hasPermission('payment-method')" class="menu-item"
                        :class="$route.name === 'payment-method.index' ? 'active' : ''">
                        <router-link :to="{ name: 'payment-method.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Payment Method
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="menu-item"
                v-if="hasPermission('reports') || hasPermission('reports.sale') || hasPermission('reports.sale-payment') || hasPermission('reports.sale-return') || hasPermission('reports.purchase') || hasPermission('reports.purchase-return') || hasPermission('reports.purchase-payment') || hasPermission('reports.stocks') || hasPermission('reports.cost') | hasPermission('reports.customer') || hasPermission('reports.supplier') || hasPermission('reports.profit')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-git-repo-forked"></i>
                    <div data-i18n="Invoice">Reports</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item"
                        v-if="hasPermission('reports.sale') || hasPermission('reports.sale-payment') || hasPermission('reports.sale-return')">
                        <router class="menu-link menu-toggle">
                            <i class='menu-icon tf-icons bx bxs-report'></i>
                            <div class="text-truncate" data-i18n="Account Settings">Sales</div>
                        </router>
                        <ul class="menu-sub">
                            <li class="menu-item" :class="$route.name === 'reports.sale' ? 'active' : ''"
                                v-if="hasPermission('reports.sale')">
                                <router-link :to="{ name: 'reports.sale' }" class="menu-link">
                                    Sale List
                                </router-link>
                            </li>
                            <li class="menu-item" :class="$route.name === 'reports.sale-payment' ? 'active' : ''"
                                v-if="hasPermission('reports.sale-payment')">
                                <router-link :to="{ name: 'reports.sale-payment' }" class="menu-link">
                                    Sale Payment
                                </router-link>
                            </li>
                            <li class="menu-item" :class="$route.name === 'reports.sale-return' ? 'active' : ''"
                                v-if="hasPermission('reports.sale-return')">
                                <router-link :to="{ name: 'reports.sale-return' }" class="menu-link">
                                    Sale Return
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item"
                        v-if="hasPermission('reports.purchase') || hasPermission('reports.purchase-return') || hasPermission('reports.purchase-payment')">
                        <router class="menu-link menu-toggle">
                            <i class='menu-icon tf-icons bx bxs-report'></i>
                            <div class="text-truncate" data-i18n="Account Settings">Purchase</div>
                        </router>
                        <ul class="menu-sub">
                            <li v-if="hasPermission('reports.purchase')" class="menu-item"
                                :class="$route.name === 'reports.purchase' ? 'active' : ''">
                                <router-link :to="{ name: 'reports.purchase' }" class="menu-link">
                                    Purchase List
                                </router-link>
                            </li>
                            <li v-if="hasPermission('reports.purchase-payment')" class="menu-item"
                                :class="$route.name === 'reports.purchase-payment' ? 'active' : ''">
                                <router-link :to="{ name: 'reports.purchase-payment' }" class="menu-link">
                                    Purchase Payment
                                </router-link>
                            </li>
                            <li v-if="hasPermission('reports.purchase-return')" class="menu-item"
                                :class="$route.name === 'reports.purchase-return' ? 'active' : ''">
                                <router-link :to="{ name: 'reports.purchase-return' }" class="menu-link">
                                    Purchase Return
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="hasPermission('reports.stocks')" class="menu-item"
                        :class="$route.name === 'reports.stock' ? 'active' : ''">
                        <router-link :to="{ name: 'reports.stock' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-check-shield"></i>
                            Stocks
                        </router-link>
                    </li>
                    <li v-if="hasPermission('reports.cost')" class="menu-item"
                        :class="$route.name === 'reports.cost' ? 'active' : ''">
                        <router-link :to="{ name: 'reports.cost' }" class="menu-link">
                            <i class='menu-icon tf-icons bx bxs-report'></i>
                            Costs
                        </router-link>
                    </li>
                    <li v-if="hasPermission('reports.customer')" class="menu-item"
                        :class="$route.name === 'reports.customer' ? 'active' : ''">
                        <router-link :to="{ name: 'reports.customer' }" class="menu-link">
                            <i class='menu-icon tf-icons bx bxs-report'></i>
                            Customers
                        </router-link>
                    </li>
                    <li v-if="hasPermission('reports.supplier')" class="menu-item"
                        :class="$route.name === 'reports.supplier' ? 'active' : ''">
                        <router-link :to="{ name: 'reports.supplier' }" class="menu-link">
                            <i class='menu-icon tf-icons bx bxs-report'></i>
                            Suppliers
                        </router-link>
                    </li>
                    <li v-if="hasPermission('reports.employee')" class="menu-item"
                        :class="$route.name === 'reports.employee' ? 'active' : ''">
                        <router-link :to="{ name: 'reports.employee' }" class="menu-link">
                            <i class='menu-icon tf-icons bx bxs-report'></i>
                            Employees
                        </router-link>
                    </li>
                    <li v-if="hasPermission('reports.salary')" class="menu-item"
                        :class="$route.name === 'reports.salary' ? 'active' : ''">
                        <router-link :to="{ name: 'reports.salary' }" class="menu-link">
                            <i class='menu-icon tf-icons bx bxs-report'></i>
                            Salary
                        </router-link>
                    </li>
                    <li v-if="hasPermission('reports.profit')" class="menu-item"
                        :class="$route.name === 'reports.profit' ? 'active' : ''">
                        <router-link :to="{ name: 'reports.profit' }" class="menu-link">
                            <i class='menu-icon tf-icons bx bxs-report'></i>
                            Profit & Loss
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="menu-item"
                v-if="hasPermission('pharmacy.index') || hasPermission('pharmacy.create') || hasPermission('pharmacy.view') || hasPermission('pharmacy.delete')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-check-shield"></i>
                    <div data-i18n="Invoice">Pharmacy</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('pharmacy.create')" class="menu-item"
                        :class="$route.name === 'pharmacy.create' ? 'active' : ''">
                        <router-link :to="{ name: 'pharmacy.create' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-add-to-queue"></i>
                            Add Pharmacy
                        </router-link>
                    </li>
                    <li v-if="hasPermission('pharmacy.index') || hasPermission('pharmacy.edit') || hasPermission('pharmacy.view')"
                        class="menu-item" :class="$route.name === 'pharmacy.index' ? 'active' : ''">
                        <router-link :to="{ name: 'pharmacy.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Pharmacy List
                        </router-link>
                    </li>

                </ul>
            </li>
            <li class="menu-item"
                v-if="hasPermission('plan.create') || hasPermission('plan.edit') || hasPermission('plan.delete') || hasPermission('plan.index')">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-planet"></i>
                    <div data-i18n="Invoice">Plans</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" :class="$route.name === 'plan.create' ? 'active' : ''"
                        v-if="hasPermission('plan.create')">
                        <router-link :to="{ name: 'plan.create' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-check-shield"></i>
                            Add Plan
                        </router-link>
                    </li>
                    <li v-if="hasPermission('plan.index') || hasPermission('plan.edit') || hasPermission('plan.delete')"
                        class="menu-item" :class="$route.name === 'plan.index' ? 'active' : ''">
                        <router-link :to="{ name: 'plan.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Plan List
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-check-shield"></i>
                    <div data-i18n="Invoice">Subscription</div>
                </a>
                <ul class="menu-sub">
                    <li v-if="hasPermission('plan.myplan')" class="menu-item"
                        :class="$route.name === 'plan.myplan' ? 'active' : ''">
                        <router-link :to="{ name: 'plan.myplan' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-add-to-queue"></i>
                            My Plan
                        </router-link>
                    </li>
                    <li v-if="hasPermission('subscription.index')"
                        class="menu-item" :class="$route.name === 'subscription.index' ? 'active' : ''">
                        <router-link :to="{ name: 'subscription.index' }" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-ol"></i>
                            Subscription
                        </router-link>
                    </li>

                </ul>
            </li> 
        </ul>
    </aside>
</template>

<script>
import { defineComponent } from 'vue';
import { Menu } from "../../../../public/backend/js/menu";
import { PerfectScrollbar } from "../../../../public/backend/libs/perfect-scrollbar/perfect-scrollbar";

export default defineComponent({
    name: 'sidebar',
    methods: {
        sidebarToggle() {
            const html = $('html');
            if (html.hasClass('layout-menu-expanded')) {
                html.removeClass('layout-menu-expanded');
            } else {
                html.addClass('layout-menu-expanded');
            }
        },
    },
    mounted() {
        const el = this.$el; // DOM element reference of the component
        const config = {}; // Configuration options for the menu
        const menu = new Menu(el, config, PerfectScrollbar);
    },
});

</script>
<style scoped>
.form-check-input[type=checkbox] {
    border: 1px solid #123 !important;
}
</style>
