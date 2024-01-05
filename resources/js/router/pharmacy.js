let pharmacy = [
  {
    path: "/medicines",
    name: "medicine.index",
    component: () => import("../components/pharmacy/medicine/index.vue"),
    meta: {
      title: "Medicine List",
      requiresAuth: true,
    },
  },
  {
    path: "/medicine/stocks",
    name: "medicine.stock",
    component: () => import("../components/pharmacy/medicine/stock.vue"),
    meta: {
      title: "Medicine List",
      requiresAuth: true,
    },
  },
  {
    path: "/medicine/create",
    name: "medicine.create",
    component: () => import("../components/pharmacy/medicine/create.vue"),
    meta: {
      title: "Add Medicine",
      requiresAuth: true,
    },
    props: {
      isEdit: false,
    },
  },
  {
    path: "/medicine/:id/edit",
    name: "medicine.edit",
    component: () => import("../components/pharmacy/medicine/create.vue"),
    meta: {
      title: "Edit Medicine",
      requiresAuth: true,
    },
    props: {
      isEdit: true,
    },
  },
  //purchase Router
  {
    path: "/purchases",
    name: "purchase.index",
    component: () => import("../components/purchase/index.vue"),
    meta: {
      title: "Purchase List",
      requiresAuth: true,
    },
  },
  {
    path: "/purchase/return",
    name: "purchase.returnlist",
    component: () => import("../components/purchase/returnlist.vue"),
    meta: {
      title: "Return List",
      requiresAuth: true,
    },
  },
  {
    path: "/purchase/create",
    name: "purchase.create",
    component: () => import("../components/purchase/create.vue"),
    meta: {
      title: "Add Purchase",
      requiresAuth: true,
    },
    props: {
      isEdit: false,
    },
  },
  {
    path: "/purchase/:id/view",
    name: "purchase.view",
    component: () => import("../components/purchase/view.vue"),
    meta: {
      title: "View Purchase",
      requiresAuth: true,
    },
  },
  {
    path: "/purchase/due-collect",
    name: "purchase.dueCollect",
    component: () => import("../components/purchase/duepayment.vue"),
    meta: {
      title: "Purchase Due Payment",
      requiresAuth: true,
    },
  },

  //Pharmacy Cost
  {
    path: "/cost",
    name: "cost.index",
    component: () => import("../components/pharmacy/cost/index.vue"),
    meta: {
      title: "Cost List",
      requiresAuth: true,
    },
  },
  //supplier Routers

  {
    path: "/suppliers",
    name: "supplier.index",
    component: () => import("../components/supplier/index.vue"),
    meta: {
      title: "Supplier List",
      requiresAuth: true,
    },
  },
  {
    path: "/supplier/create",
    name: "supplier.create",
    component: () => import("../components/supplier/create.vue"),
    meta: {
      title: "Supplier Create",
      requiresAuth: true,
    },
  },
  {
    path: "/supplier/:id/edit",
    name: "supplier.edit",
    component: () => import("../components/supplier/edit.vue"),
    meta: {
      title: "Edit Supplier",
      requiresAuth: true,
    },
  },
  {
    path: "/supplier/:id/view",
    name: "supplier.view",
    component: () => import("../components/supplier/View.vue"),
    meta: {
      title: "View Suppliers",
      requiresAuth: true,
    },
  },
  //Customer Router
  {
    path: "/customer",
    name: "customer.index",
    component: () => import("../components/customer/index.vue"),
    meta: {
      title: "Customer List",
      requiresAuth: true,
    },
  },
  {
    path: "/customer/create",
    name: "customer.create",
    component: () => import("../components/customer/create.vue"),
    meta: {
      title: "Create Customer",
      requiresAuth: true,
    },
  },

  {
    path: "/customer/:id/edit",
    name: "customer.edit",
    component: () => import("../components/customer/edit.vue"),
    meta: {
      title: "Edit Customer",
      requiresAuth: true,
    },
  },
  {
    path: "/customer/:id/view",
    name: "customer.view",
    component: () => import("../components/customer/View.vue"),
    meta: {
      title: "Customer Info",
      requiresAuth: true,
    },
  },
  //Pharmacy Plan
  {
    path: "/current-plan",
    name: "plan.myplan",
    component: () => import("../components/plan/myplan.vue"),
    meta: {
      title: "Employee List",
      requiresAuth: true,
    },
  },
  //Employee Router
  {
    path: "/employee",
    name: "employee.index",
    component: () => import("../components/employee/index.vue"),
    meta: {
      title: "Employee List",
      requiresAuth: true,
    },
  },
  {
    path: "/employee/create",
    name: "employee.create",
    component: () => import("../components/employee/create.vue"),
    meta: {
      title: "Create employee",
      requiresAuth: true,
    },
  },

  {
    path: "/employee/:id/edit",
    name: "employee.edit",
    component: () => import("../components/employee/edit.vue"),
    meta: {
      title: "Edit employee",
      requiresAuth: true,
    },
  },
  {
    path: "/employee/:id/view",
    name: "employee.view",
    component: () => import("../components/employee/View.vue"),
    meta: {
      title: "employee Info",
      requiresAuth: true,
    },
  },
  //Employee Salary Router
  {
    path: "/salary",
    name: "salary.index",
    component: () => import("../components/employee/salary/index.vue"),
    meta: {
      title: "Salary List",
      requiresAuth: true,
    },
  },
  {
    path: "/salary/advance-pay",
    name: "salary.advancelist",
    component: () => import("../components/employee/salary/advancelist.vue"),
    meta: {
      title: "Advance Salary List",
      requiresAuth: true,
    },
  },
  //Category Router
  {
    path: "/category",
    name: "category.index",
    component: () => import("../components/pharmacy/categories/index.vue"),
    meta: {
      title: "Category List",
      requiresAuth: true,
    },
  },
  {
    path: "/category/:id/edit",
    name: "category.edit",
    component: () => import("../components/pharmacy/categories/edit.vue"),
    meta: {
      title: "Edit Category",
      requiresAuth: true,
    },
  },
  {
    path: "/units",
    name: "unit.index",
    component: () => import("../components/pharmacy/units/index.vue"),
    meta: {
      title: "Unit List",
      requiresAuth: true,
    },
  },
  {
    path: "/types",
    name: "type.index",
    component: () => import("../components/pharmacy/type/index.vue"),
    meta: {
      title: "Type List",
      requiresAuth: true,
    },
  },
  //leaf Router
  {
    path: "/leaf",
    name: "leaf.index",
    component: () => import("../components/pharmacy/leaf/index.vue"),
    meta: {
      title: "Leaf List",
      requiresAuth: true,
    },
  },
  {
    path: "/shelf",
    name: "shelf.index",
    component: () => import("../components/pharmacy/shelf/index.vue"),
    meta: {
      title: "Shelf List",
      requiresAuth: true,
    },
  },
  //Paymnet Router
  {
    path: "/payment",
    name: "payment-method.index",
    component: () => import("../components/pharmacy/paymentMethods/index.vue"),
    meta: {
      title: "Payment Methods",
      requiresAuth: true,
    },
  },
  //balance Router
  {
    path: "/balance",
    name: "balance.index",
    component: () => import("../components/balance/index.vue"),
    meta: {
      title: "Balance Info",
      requiresAuth: true,
    },
  },
  //Manufacture Router
  {
    path: "/manufacturer",
    name: "manufacturer.index",
    component: () => import("../components/manufacturer/index.vue"),
    meta: {
      title: "Manufacturer List",
      requiresAuth: true,
    },
  },
  {
    path: "/manufacturer/create",
    name: "manufacturer.create",
    component: () => import("../components/manufacturer/create.vue"),
    meta: {
      title: "Create manufacturer",
      requiresAuth: true,
    },
    props: {
      isEdit: false,
    },
  },
  {
    path: "/manufacturer/:id/edit",
    name: "manufacturer.edit",
    component: () => import("../components/manufacturer/create.vue"),
    meta: {
      title: "Edit manufacturer",
      requiresAuth: true,
    },
    props: {
      isEdit: true,
    },
  },
  //Sale Router
  {
    path: "sale",
    name: "sale.create",
    component: () => import("../components/sales/create.vue"),
    meta: {
      title: "POS",
      requiresAuth: true,
    },
  },
  {
    path: "sale/list",
    name: "sale.index",
    component: () => import("../components/sales/index.vue"),
    meta: {
      title: "Sale List",
      requiresAuth: true,
    },
  },
  {
    path: "sale/return",
    name: "sale.returnlist",
    component: () => import("../components/sales/returnlist.vue"),
    meta: {
      title: "Sale Return",
      requiresAuth: true,
    },
  },
  {
    path: "/sale/:id/view",
    name: "sale.view",
    component: () => import("../components/sales/view.vue"),
    meta: {
      title: "Sale Details",
      requiresAuth: true,
    },
  },
  {
    path: "/sale/due-collect",
    name: "sale.dueCollect",
    component: () => import("../components/sales/dueCollect.vue"),
    meta: {
      title: "Sale Deu Collect",
      requiresAuth: true,
    },
  },
  {
    path: "/sale/exchange",
    name: "sale.exchange",
    component: () => import("../components/sales/exchange.vue"),
    meta: {
      title: "Sale Exchange",
      requiresAuth: true,
    },
  },
  //Reports
  {
    path: "reports/purchase",
    name: "reports.purchase",
    component: () => import("../components/reports/Purchase.vue"),
    meta: {
      title: "purchase List",
      requiresAuth: true,
    },
  },
  {
    path: "reports/purchase-payment",
    name: "reports.purchase-payment",
    component: () => import("../components/reports/PurchasePayment.vue"),
    meta: {
      title: "purchase List",
      requiresAuth: true,
    },
  },
  {
    path: "reports/purchase-return",
    name: "reports.purchase-return",
    component: () => import("../components/reports/PurchaseReturns.vue"),
    meta: {
      title: "purchase List",
      requiresAuth: true,
    },
  },

  // Sale Report
  {
    path: "reports/sale",
    name: "reports.sale",
    component: () => import("../components/reports/Sale.vue"),
    meta: {
      title: "Sale List",
      requiresAuth: true,
    },
  },
  {
    path: "reports/sale-payment",
    name: "reports.sale-payment",
    component: () => import("../components/reports/SalePayment.vue"),
    meta: {
      title: "Sale Payment Report",
      requiresAuth: true,
    },
  },
  {
    path: "reports/sale-return",
    name: "reports.sale-return",
    component: () => import("../components/reports/SaleReturns.vue"),
    meta: {
      title: "Sale Return Reports",
      requiresAuth: true,
    },
  },
  {
    path: "reports/stocks",
    name: "reports.stock",
    component: () => import("../components/reports/Stock.vue"),
    meta: {
      title: "Stock Report",
      requiresAuth: true,
    },
  },
  {
    path: "reports/cost",
    name: "reports.cost",
    component: () => import("../components/reports/Cost.vue"),
    meta: {
      title: "Cost Report",
      requiresAuth: true,
    },
  },
  {
    path: "reports/customer",
    name: "reports.customer",
    component: () => import("../components/reports/Customer.vue"),
    meta: {
      title: "Customer Report",
      requiresAuth: true,
    },
  },
  {
    path: "reports/employee",
    name: "reports.employee",
    component: () => import("../components/reports/Employee.vue"),
    meta: {
      title: "Employee Report",
      requiresAuth: true,
    },
  },
  {
    path: "reports/salary",
    name: "reports.salary",
    component: () => import("../components/reports/Salary.vue"),
    meta: {
      title: "Salary Report",
      requiresAuth: true,
    },
  },
  {
    path: "reports/supplier",
    name: "reports.supplier",
    component: () => import("../components/reports/Supplier.vue"),
    meta: {
      title: "Supplier Report",
      requiresAuth: true,
    },
  },
  {
    path: "reports/profit-loss",
    name: "reports.profit",
    component: () => import("../components/reports/Profit.vue"),
    meta: {
      title: "Profit & Loss",
      requiresAuth: true,
    },
  },
];
export default pharmacy;
