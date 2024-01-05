<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Custom Permissions
        //name=Permission Name
        //display_name=Permission Display Name
        //module=Module Name
        //description=Permission Description
        //type=Permission Type (1=View, 2=Insert, 3=edit, 4=status, 5=delete,6=Detail View)

        //if description === MODULE than it is a module
        //if description === FEATURE than it is a feature of module
        //if display_name === description is for grouping of permissions
        $permissions = [

            // Pharmecy Base RBAC Access Control Module
            [
                'name' => 'rbac',
                'display_name' => 'RBAC',
                'module' => null,
                'description' => 'MODULE',
                'type' => null,
            ],
            //Role
            [
                'name' => 'role',
                'display_name' => 'Role',
                'module' => 'RBAC',
                'description' => 'FEATURE',
                'type' => null,
            ],
            [
                'name' => 'role.index',
                'display_name' => 'Role List',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 1,
            ],
            [
                'name' => 'role.create',
                'display_name' => 'Role Insert',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 2,
            ],
            [
                'name' => 'role.edit', //these names comes from route.js
                'display_name' => 'Role Edit',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 3,
            ],
            [
                'name' => 'role.delete',
                'display_name' => 'Role Delete',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 5,
            ],
            [
                'name' => 'role.view',
                'display_name' => 'Role View',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 6,
            ],
            [
                'name' => 'role.assign-permission',
                'display_name' => 'Assign Permission',
                'module' => 'RBAC',
                'description' => 'Role',
                'type' => 6,
            ],
            //Subscription
            [
                'name' => 'subscription',
                'display_name' => 'Subscription',
                'module' => null,
                'description' => 'MODULE',
                'type' => null,
            ],
            //Role
            [
                'name' => 'Plan',
                'display_name' => 'Plan',
                'module' => 'Subscription',
                'description' => 'FEATURE',
                'type' => null,
            ],
            [
                'name' => 'plan.index',
                'display_name' => 'Plan List',
                'module' => 'Subscription',
                'description' => 'Plan',
                'type' => 1,
            ],
            [
                'name' => 'plan.create',
                'display_name' => 'Plan Insert',
                'module' => 'Subscription',
                'description' => 'Plan',
                'type' => 2,
            ],
            [
                'name' => 'plan.edit', //these names comes from route.js
                'display_name' => 'Plan Edit',
                'module' => 'Subscription',
                'description' => 'Plan',
                'type' => 3,
            ],
            [
                'name' => 'plan.delete',
                'display_name' => 'Plan Delete',
                'module' => 'Subscription',
                'description' => 'Plan',
                'type' => 5,
            ],
            [
                'name' => 'plan.view',
                'display_name' => 'Plan View',
                'module' => 'Subscription',
                'description' => 'Plan',
                'type' => 6,
            ],
            [
                'name' => 'plan.assign-permission',
                'display_name' => 'Assign Permission',
                'module' => 'Subscription',
                'description' => 'Plan',
                'type' => 6,
            ],
            [
                'name' => 'subscribe',
                'display_name' => 'Subscribe',
                'module' => 'Subscription',
                'description' => 'FEATURE',
                'type' => null,
            ],
            [
                'name' => 'subscription.index',
                'display_name' => 'Subscription List',
                'module' => 'Subscription',
                'description' => 'Subscribe',
                'type' => 1,
            ],
            [
                'name' => 'subscription.assign-permission',
                'display_name' => 'Assign Subscription',
                'module' => 'Subscription',
                'description' => 'Subscribe',
                'type' => 6,
            ],
            [
                'name' => 'subscription.renew',
                'display_name' => 'Renew Subscription',
                'module' => 'Subscription',
                'description' => 'Subscribe',
                'type' => 6,
            ],
            [
                'name' => 'pharmacy-management',
                'display_name' => 'PHARMACY MANAGEMENT',
                'module' => null,
                'description' => 'MODULE',
                'type' => null,
            ],
            //Pharmacy
            [
                'name' => 'pharmacy',
                'display_name' => 'Pharmacy',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            [
                'name' => 'dashboard',
                'display_name' => 'Dashboard',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            [
                'name' => 'summary',
                'display_name' => 'Summary',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Dashboard',
                'type' => 1,
            ],
            [
                'name' => 'stock-out',
                'display_name' => 'Stock Out',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Dashboard',
                'type' => 1,
            ],
            // Pharmacy Feature wise Permission
            [
                'name' => 'pharmacy.index',
                'display_name' => 'Pharmacy List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Pharmacy',
                'type' => 1,
            ],
            [
                'name' => 'pharmacy.create',
                'display_name' => 'Pharmacy Insert',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Pharmacy',
                'type' => 2,
            ],
            [
                'name' => 'pharmacy.edit', //these names comes from route.js
                'display_name' => 'Pharmacy Edit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Pharmacy',
                'type' => 3,
            ],
            [
                'name' => 'pharmacy.status',
                'display_name' => 'Pharmacy Status',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Pharmacy',
                'type' => 4,
            ],
            [
                'name' => 'pharmacy.delete',
                'display_name' => 'Pharmacy Delete',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Pharmacy',
                'type' => 5,
            ],
            [
                'name' => 'pharmacy.view',
                'display_name' => 'Pharmacy View',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Pharmacy',
                'type' => 6,
            ],
            //Manufacturer
            [
                'name' => 'manufacturer',
                'display_name' => 'Manufacturer',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Manufacturer Feature wise Permission
            [
                'name' => 'manufacturer.index',
                'display_name' => 'Manufacturer List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Manufacturer',
                'type' => 1,
            ],
            [
                'name' => 'manufacturer.create',
                'display_name' => 'Manufacturer Insert',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Manufacturer',
                'type' => 2,
            ],
            [
                'name' => 'manufacturer.edit', //these names comes from route.js
                'display_name' => 'Manufacturer Edit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Manufacturer',
                'type' => 3,
            ],
            [
                'name' => 'manufacturer.status',
                'display_name' => 'Manufacturer Status',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Manufacturer',
                'type' => 4,
            ],
            [
                'name' => 'manufacturer.delete',
                'display_name' => 'Manufacturer Delete',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Manufacturer',
                'type' => 5,
            ],
            [
                'name' => 'manufacturer.view',
                'display_name' => 'Manufacturer View',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Manufacturer',
                'type' => 6,
            ],
            // Employee
            [
                'name' => 'user',
                'display_name' => 'Employee',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Pharmacy Employee Feature wise Permission
            [
                'name' => 'user.index',
                'display_name' => 'Employee List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Employee',
                'type' => 1,
            ],
            [
                'name' => 'user.create',
                'display_name' => 'Employee Insert',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Employee',
                'type' => 2,
            ],
            [
                'name' => 'user.edit', //these names comes from route.js
                'display_name' => 'Employee Edit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Employee',
                'type' => 3,
            ],
            [
                'name' => 'user.status',
                'display_name' => 'Employee Status',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Employee',
                'type' => 4,
            ],
            [
                'name' => 'user.delete',
                'display_name' => 'Employee Delete',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Employee',
                'type' => 5,
            ],
            // Customer
            [
                'name' => 'customer',
                'display_name' => 'Customer',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Pharmacy Customer Feature wise Permission
            [
                'name' => 'customer.index',
                'display_name' => 'Customer List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Customer',
                'type' => 1,
            ],
            [
                'name' => 'customer.create',
                'display_name' => 'Customer Insert',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Customer',
                'type' => 2,
            ],
            [
                'name' => 'customer.edit', //these names comes from route.js
                'display_name' => 'Customer Edit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Customer',
                'type' => 3,
            ],
            [
                'name' => 'customer.status',
                'display_name' => 'Customer Status',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Customer',
                'type' => 4,
            ],
            [
                'name' => 'customer.delete',
                'display_name' => 'Customer Delete',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Customer',
                'type' => 5,
            ],
            // Pharmacy Supplier Feature
            [
                'name' => 'supplier',
                'display_name' => 'Supplier',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Pharmacy Customer Feature wise Permission
            [
                'name' => 'supplier.index',
                'display_name' => 'Supplier List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Supplier',
                'type' => 1,
            ],
            [
                'name' => 'supplier.create',
                'display_name' => 'Supplier Insert',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Supplier',
                'type' => 2,
            ],
            [
                'name' => 'supplier.edit', //these names comes from route.js
                'display_name' => 'Supplier Edit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Supplier',
                'type' => 3,
            ],
            [
                'name' => 'supplier.status',
                'display_name' => 'Supplier Status',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Supplier',
                'type' => 4,
            ],
            [
                'name' => 'supplier.delete',
                'display_name' => 'Supplier Delete',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Supplier',
                'type' => 5,
            ],
            [
                'name' => 'supplier.view',
                'display_name' => 'Supplier View',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Supplier',
                'type' => 6,
            ],
            [
                'name' => 'sale',
                'display_name' => 'Sale',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            [
                'name' => 'sale.index',
                'display_name' => 'Sale List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Sale',
                'type' => 1,
            ],
            [
                'name' => 'sale.create',
                'display_name' => 'Sale Create',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Sale',
                'type' => 2,
            ],
            [
                'name' => 'sale.view',
                'display_name' => 'Sale Details',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Sale',
                'type' => 6,
            ],
            [
                'name' => 'sale.return-create',
                'display_name' => 'Sale Return Create',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Sale',
                'type' => 6,
            ],
            [
                'name' => 'sale.returnlist',
                'display_name' => 'Sale Return list',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Sale',
                'type' => 6,
            ],
            //Purchase
            [
                'name' => 'purchase',
                'display_name' => 'Purchase',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            [
                'name' => 'purchase.index',
                'display_name' => 'Purchase List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Purchase',
                'type' => 1,
            ],
            [
                'name' => 'purchase.create',
                'display_name' => 'Purchase Create',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Purchase',
                'type' => 2,
            ],
            [
                'name' => 'purchase.view',
                'display_name' => 'Purchase Details',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Purchase',
                'type' => 6,
            ],
            [
                'name' => 'purchase.return-create',
                'display_name' => 'Purchase Return Create',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Purchase',
                'type' => 6,
            ],
            [
                'name' => 'purchase.returnlist',
                'display_name' => 'Purchase Return list',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Purchase',
                'type' => 6,
            ],
            [
                'name' => 'medicine',
                'display_name' => 'Medicine',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Pharmacy Feature wise Permission
            [
                'name' => 'medicine.index',
                'display_name' => 'Medicine List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Medicine',
                'type' => 1,
            ],
            [
                'name' => 'medicine.create',
                'display_name' => 'Medicine Insert',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Medicine',
                'type' => 2,
            ],
            [
                'name' => 'medicine.edit', //these names comes from route.js
                'display_name' => 'Medicine Edit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Medicine',
                'type' => 3,
            ],
            [
                'name' => 'medicine.status',
                'display_name' => 'Medicine Status',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Medicine',
                'type' => 4,
            ],
            [
                'name' => 'medicine.delete',
                'display_name' => 'Medicine Delete',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Medicine',
                'type' => 5,
            ],
            [
                'name' => 'medicine.view',
                'display_name' => 'Medicine View',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Medicine',
                'type' => 6,
            ],
            [
                'name' => 'category',
                'display_name' => 'Category',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Pharmacy Feature wise Permission
            [
                'name' => 'category.index',
                'display_name' => 'Category List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Category',
                'type' => 1,
            ],
            [
                'name' => 'category.create',
                'display_name' => 'Category Insert',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Category',
                'type' => 2,
            ],
            [
                'name' => 'category.edit', //these names comes from route.js
                'display_name' => 'Category Edit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Category',
                'type' => 3,
            ],
            [
                'name' => 'category.status',
                'display_name' => 'Category Status',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Category',
                'type' => 4,
            ],
            [
                'name' => 'category.delete',
                'display_name' => 'Category Delete',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Category',
                'type' => 5,
            ],
            [
                'name' => 'category.view',
                'display_name' => 'Category View',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Category',
                'type' => 6,
            ],
            //Leaf
            [
                'name' => 'leaf',
                'display_name' => 'Leaf',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Pharmacy Feature wise Permission
            [
                'name' => 'leaf.index',
                'display_name' => 'Leaf List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Leaf',
                'type' => 1,
            ],
            [
                'name' => 'leaf.create',
                'display_name' => 'Leaf Insert',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Leaf',
                'type' => 2,
            ],
            [
                'name' => 'leaf.edit', //these names comes from route.js
                'display_name' => 'Leaf Edit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Leaf',
                'type' => 3,
            ],
            [
                'name' => 'leaf.status',
                'display_name' => 'Leaf Status',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Leaf',
                'type' => 4,
            ],
            [
                'name' => 'leaf.delete',
                'display_name' => 'Leaf Delete',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Leaf',
                'type' => 5,
            ],
            [
                'name' => 'leaf.view',
                'display_name' => 'Leaf View',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Leaf',
                'type' => 6,
            ],
            //Type
            [
                'name' => 'type',
                'display_name' => 'Type',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Pharmacy Feature wise Permission
            [
                'name' => 'type.index',
                'display_name' => 'Type List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Type',
                'type' => 1,
            ],
            [
                'name' => 'type.create',
                'display_name' => 'Type Insert',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Type',
                'type' => 2,
            ],
            [
                'name' => 'type.edit', //these names comes from route.js
                'display_name' => 'type Edit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Type',
                'type' => 3,
            ],
            [
                'name' => 'type.status',
                'display_name' => 'Type Status',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Type',
                'type' => 4,
            ],
            [
                'name' => 'type.delete',
                'display_name' => 'Type Delete',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Type',
                'type' => 5,
            ],
            [
                'name' => 'type.view',
                'display_name' => 'Type View',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Type',
                'type' => 6,
            ],
            //Shelf
            [
                'name' => 'shelf',
                'display_name' => 'Shelf',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Pharmacy Feature wise Permission
            [
                'name' => 'shelf.index',
                'display_name' => 'Shelf List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Shelf',
                'type' => 1,
            ],
            [
                'name' => 'shelf.create',
                'display_name' => 'Shelf Insert',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Shelf',
                'type' => 2,
            ],
            [
                'name' => 'shelf.edit', //these names comes from route.js
                'display_name' => 'Shelf Edit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Shelf',
                'type' => 3,
            ],
            [
                'name' => 'shelf.status',
                'display_name' => 'Shelf Status',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Shelf',
                'type' => 4,
            ],
            [
                'name' => 'shelf.delete',
                'display_name' => 'Shelf Delete',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Shelf',
                'type' => 5,
            ],
            [
                'name' => 'shelf.view',
                'display_name' => 'Shelf View',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Shelf',
                'type' => 6,
            ],
            //Unit
            [
                'name' => 'unit',
                'display_name' => 'Unit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Pharmacy Feature wise Permission
            [
                'name' => 'unit.index',
                'display_name' => 'Unit List',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Unit',
                'type' => 1,
            ],
            [
                'name' => 'unit.create',
                'display_name' => 'Unit Insert',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Unit',
                'type' => 2,
            ],
            [
                'name' => 'unit.edit', //these names comes from route.js
                'display_name' => 'Unit Edit',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Unit',
                'type' => 3,
            ],
            [
                'name' => 'unit.status',
                'display_name' => 'Unit Status',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Unit',
                'type' => 4,
            ],
            [
                'name' => 'unit.delete',
                'display_name' => 'Unit Delete',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Unit',
                'type' => 5,
            ],
            [
                'name' => 'unit.view',
                'display_name' => 'Unit View',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Unit',
                'type' => 6,
            ],
            //Reports Module
            [
                'name' => 'report',
                'display_name' => 'Reports',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'FEATURE',
                'type' => null,
            ],
            [
                'name' => 'reports.purchase',
                'display_name' => 'Purchase Report',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Reports',
                'type' => 1,
            ],
            [
                'name' => 'reports.purchase-payment',
                'display_name' => 'Purchase Payment',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Reports',
                'type' => 1,
            ],
            [
                'name' => 'reports.purchase-return',
                'display_name' => 'Purchase Return Report',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Reports',
                'type' => 1,
            ],
            [
                'name' => 'reports.sale',
                'display_name' => 'Sale Report',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Reports',
                'type' => 1,
            ],
            [
                'name' => 'reports.sale-return',
                'display_name' => 'Sale Return Report',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Reports',
                'type' => 1,
            ],
            [
                'name' => 'reports.sale-payment',
                'display_name' => 'Sale Payment',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Reports',
                'type' => 1,
            ],
            [
                'name' => 'reports.stock',
                'display_name' => 'Stock Reports',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Reports',
                'type' => 1,
            ],
            [
                'name' => 'reports.cost',
                'display_name' => 'Cost Reports',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Reports',
                'type' => 1,
            ],
            [
                'name' => 'reports.customer',
                'display_name' => 'Customer Reports',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Reports',
                'type' => 1,
            ],
            [
                'name' => 'reports.supplier',
                'display_name' => 'Supplier Reports',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Reports',
                'type' => 1,
            ],
            [
                'name' => 'reports.profit',
                'display_name' => 'Profit and Los',
                'module' => 'PHARMACY MANAGEMENT',
                'description' => 'Reports',
                'type' => 1,
            ],
            // Account Base Access Control Module
            [
                'name' => 'account',
                'display_name' => 'Accounts',
                'module' => null,
                'description' => 'MODULE',
                'type' => null,
            ],
            // Account Feature
            [
                'name' => 'balance',
                'display_name' => 'Balance',
                'module' => 'Accounts',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Account Feature wise Permission
            [
                'name' => 'balance.index',
                'display_name' => 'Balance History',
                'module' => 'Accounts',
                'description' => 'Balance',
                'type' => 1,
            ],
            [
                'name' => 'balance.create',
                'display_name' => 'Balance Insert',
                'module' => 'Accounts',
                'description' => 'Balance',
                'type' => 2,
            ],
            [
                'name' => 'balance.edit',
                'display_name' => 'Balance Edit',
                'module' => 'Accounts',
                'description' => 'Balance',
                'type' => 3,
            ],
            [
                'name' => 'balance.delete',
                'display_name' => 'Balance Delete',
                'module' => 'Accounts',
                'description' => 'Balance',
                'type' => 6,
            ],
            [
                'name' => 'cost',
                'display_name' => 'Cost',
                'module' => 'Accounts',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Account Cost Feature wise Permission
            [
                'name' => 'cost.index',
                'display_name' => 'Cost List',
                'module' => 'Accounts',
                'description' => 'Cost',
                'type' => 1,
            ],
            [
                'name' => 'cost.add',
                'display_name' => 'Cost Add',
                'module' => 'Accounts',
                'description' => 'Cost',
                'type' => 2,
            ],
            [
                'name' => 'cost.edit',
                'display_name' => 'Cost Edit',
                'module' => 'Accounts',
                'description' => 'Cost',
                'type' => 3,
            ],
            [
                'name' => 'cost.delete',
                'display_name' => 'Cost Delete',
                'module' => 'Accounts',
                'description' => 'Cost',
                'type' => 4,
            ],
            [
                'name' => 'payment-method',
                'display_name' => 'Payment Method',
                'module' => 'Accounts',
                'description' => 'FEATURE',
                'type' => null,
            ],
            // Account Cost Feature wise Permission
            [
                'name' => 'payment-method.index',
                'display_name' => 'Payment Methdo List',
                'module' => 'Accounts',
                'description' => 'Payment Method',
                'type' => 1,
            ],
            [
                'name' => 'payment-method.add',
                'display_name' => 'Payment Methdo Add',
                'module' => 'Accounts',
                'description' => 'Payment Methdo',
                'type' => 2,
            ],
            [
                'name' => 'payment-method.edit',
                'display_name' => 'Payment Method Edit',
                'module' => 'Accounts',
                'description' => 'Payment Method',
                'type' => 3,
            ],
            [
                'name' => 'payment-method.delete',
                'display_name' => 'Payment Methdo Delete',
                'module' => 'Accounts',
                'description' => 'Payment Methdo',
                'type' => 4,
            ],
        ];
        foreach ($permissions as $permissionData) {
            // find or create a permission with the same name
            Permission::firstOrCreate(['name' => $permissionData['name']], $permissionData);
        }
    }
}
