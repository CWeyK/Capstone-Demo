<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->push('Users', route('admin.users.index'));
});

Breadcrumbs::for('user-profile', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user');
    $trail->push($user->name, route('admin.users.show', $user));
});

Breadcrumbs::for('user-show', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user-profile', $user);
    $trail->push('Overview');
});

Breadcrumbs::for('user-edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user-profile', $user);
    $trail->push('Settings');
});

Breadcrumbs::for('user-bank', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user-profile', $user);
    $trail->push('Bank');
});

Breadcrumbs::for('user-tree', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user-profile', $user);
    $trail->push('Family Tree');
});

Breadcrumbs::for('user-payout', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user-profile', $user);
    $trail->push('Payouts');
});

Breadcrumbs::for('user-withdrawal', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user-profile', $user);
    $trail->push('Withdrawals');
});

Breadcrumbs::for('customer', function (BreadcrumbTrail $trail) {
    $trail->push('Customers', route('admin.customers.index'));
});

Breadcrumbs::for('customer-show', function (BreadcrumbTrail $trail, $customer) {
    $trail->parent('customer');
    $trail->push($customer->name, route('admin.customers.show', $customer));
});

Breadcrumbs::for('group', function (BreadcrumbTrail $trail) {
    $trail->push('Groups', route('admin.groups.index'));
});

Breadcrumbs::for('group-show', function (BreadcrumbTrail $trail, $group) {
    $trail->parent('group');
    $trail->push($group->name, route('admin.groups.show', $group));
});

Breadcrumbs::for('role', function (BreadcrumbTrail $trail) {
    $trail->push('Roles', route('admin.roles.index'));
});

Breadcrumbs::for('role-show', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('role');
    $trail->push($role->name, route('admin.roles.show', $role));
});

Breadcrumbs::for('permission', function (BreadcrumbTrail $trail) {
    $trail->push('Permissions', route('admin.permissions.index'));
});

Breadcrumbs::for('product', function (BreadcrumbTrail $trail) {
    $trail->push('Products', route('admin.products.index'));
});

Breadcrumbs::for('product-show', function (BreadcrumbTrail $trail, $product) {
    $trail->parent('product');
    $trail->push($product->name, route('admin.products.show', $product));
});

Breadcrumbs::for('product-create', function (BreadcrumbTrail $trail) {
    $trail->parent('product');
    $trail->push('Add Product');
});

Breadcrumbs::for('wakaf', function (BreadcrumbTrail $trail) {
    $trail->push('Wakafs', route('admin.wakafs.index'));
});

Breadcrumbs::for('wakaf-show', function (BreadcrumbTrail $trail, $wakaf) {
    $trail->parent('wakaf');
    $trail->push($wakaf->name, route('admin.wakafs.show', $wakaf));
});

Breadcrumbs::for('wakaf-create', function (BreadcrumbTrail $trail) {
    $trail->parent('wakaf');
    $trail->push('Add Wakaf');
});

Breadcrumbs::for('category', function (BreadcrumbTrail $trail) {
    $trail->push('Categories', route('admin.categories.index'));
});

Breadcrumbs::for('category-show', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('category');
    $trail->push($category->name, route('admin.categories.show', $category));
});

Breadcrumbs::for('order', function (BreadcrumbTrail $trail) {
    $trail->push('Orders', route('admin.orders.index'));
});

Breadcrumbs::for('order-show', function (BreadcrumbTrail $trail, $order) {
    $trail->parent('order');
    $trail->push($order->no, route('admin.orders.show', $order));
});

Breadcrumbs::for('shipping', function (BreadcrumbTrail $trail) {
    $trail->push('Shippings');
});

Breadcrumbs::for('transaction', function (BreadcrumbTrail $trail) {
    $trail->push('Transactions', route('admin.transactions.index'));
});

Breadcrumbs::for('event', function (BreadcrumbTrail $trail) {
    $trail->push('Events', route('admin.events.index'));
});

Breadcrumbs::for('event-profile', function (BreadcrumbTrail $trail, $event) {
    $trail->parent('event');
    $trail->push($event->name, route('admin.events.show', $event));
});

Breadcrumbs::for('event-show', function (BreadcrumbTrail $trail, $event) {
    $trail->parent('event-profile', $event);
    $trail->push('Overview');
});

Breadcrumbs::for('event-edit', function (BreadcrumbTrail $trail, $event) {
    $trail->parent('event-profile', $event);
    $trail->push('Settings');
});

Breadcrumbs::for('event-products', function (BreadcrumbTrail $trail, $event) {
    $trail->parent('event-profile', $event);
    $trail->push('Products');
});

Breadcrumbs::for('provider', function (BreadcrumbTrail $trail) {
    $trail->push('Shipping Providers', route('admin.providers.index'));
});

Breadcrumbs::for('provider-show', function (BreadcrumbTrail $trail, $provider) {
    $trail->parent('provider');
    $trail->push($provider->name, route('admin.providers.show', $provider));
});

Breadcrumbs::for('country', function (BreadcrumbTrail $trail) {
    $trail->push('Countries', route('admin.countries.index'));
});

Breadcrumbs::for('voucher', function (BreadcrumbTrail $trail) {
    $trail->push('Vouchers', route('admin.vouchers.index'));
});

Breadcrumbs::for('voucher-show', function (BreadcrumbTrail $trail, $voucher) {
    $trail->parent('voucher');
    $trail->push($voucher->name, route('admin.vouchers.show', $voucher));
});

Breadcrumbs::for('voucher-create', function (BreadcrumbTrail $trail) {
    $trail->parent('voucher');
    $trail->push('Add Voucher', route('admin.vouchers.create'));
});

Breadcrumbs::for('commission', function (BreadcrumbTrail $trail) {
    $trail->push('Commissions', route('admin.commissions.index'));
});

Breadcrumbs::for('payout', function (BreadcrumbTrail $trail) {
    $trail->push('Payouts', route('admin.payouts.index'));
});

Breadcrumbs::for('payout-show', function (BreadcrumbTrail $trail, $payout) {
    $trail->parent('payout');
    $trail->push($payout->code, route('admin.payouts.show', $payout));
});

Breadcrumbs::for('withdrawal', function (BreadcrumbTrail $trail) {
    $trail->push('Withdrawals', route('admin.withdrawals.index'));
});

Breadcrumbs::for('withdrawal-show', function (BreadcrumbTrail $trail, $withdrawal) {
    $trail->parent('withdrawal');
    $trail->push($withdrawal->code, route('admin.withdrawals.show', $withdrawal));
});

Breadcrumbs::for('adspend', function (BreadcrumbTrail $trail) {
    $trail->push('Ad Spend', route('admin.adspends.index'));
});

Breadcrumbs::for('adspend-show', function (BreadcrumbTrail $trail, $adspend) {
    $trail->parent('adspend');
    $trail->push($adspend->code, route('admin.adspends.show', $adspend));
});
