```html
<h1 align="center">👗 AlMe Pahiran</h1>

<h3 align="center">
Nepali Traditional Clothing Ecommerce Website
</h3>

<p align="center">
A university student group ecommerce project for Nepali traditional clothing and accessories.
</p>

<hr>

<h2>📖 Project Overview</h2>

<p>
<strong>AlMe Pahiran</strong> is a PHP & MySQL based ecommerce website focused on selling
Nepali traditional clothing and accessories such as:
</p>

<ul>
  <li>Sari</li>
  <li>Kurtha</li>
  <li>Dhaka-inspired clothing</li>
  <li>Traditional Nepali fashion accessories</li>
</ul>

<p>
Customers can browse products like a normal ecommerce website, but they must create an account and login before placing an order.
</p>

<p>
This project uses a <strong>manual order request system</strong>. No online payment gateway is integrated. Sellers contact customers manually through phone or social media after an order is placed.
</p>

<hr>

<h2>👨‍💻 Team Members</h2>

<table>
  <tr>
    <th>Name</th>
    <th>Role</th>
  </tr>
  <tr>
    <td><strong>SHRESTHA UTTAM</strong></td>
    <td>Team Leader</td>
  </tr>
  <tr>
    <td><strong>THAPA MANISHA</strong></td>
    <td>Member</td>
  </tr>
  <tr>
    <td><strong>SHRESTHA PRAGESH</strong></td>
    <td>Member</td>
  </tr>
  <tr>
    <td><strong>KHAND THAKURI SHRADDHA</strong></td>
    <td>Member</td>
  </tr>
</table>

<hr>

<h2>🛠 Technologies Used</h2>

<ul>
  <li>PHP</li>
  <li>HTML</li>
  <li>CSS</li>
  <li>MySQL</li>
  <li>PHP mysqli connection</li>
  <li>PHP Sessions</li>
  <li>PHP <code>password_hash()</code> and <code>password_verify()</code></li>
</ul>

<h3>❌ Not Used</h3>

<p>
No Laravel, React, Bootstrap, Tailwind, Node.js, JavaScript frameworks, APIs, or external backend frameworks are used.
</p>

<hr>

<h2>✨ Main Features</h2>

<h3>🛍 Customer Features</h3>

<ul>
  <li>Dynamic homepage with CSS-only banner slider</li>
  <li>Dynamic product listing from MySQL</li>
  <li>Dynamic categories from MySQL</li>
  <li>Product search and category filter</li>
  <li>Dynamic product detail pages</li>
  <li>Multiple product images</li>
  <li>Related products</li>
  <li>Available product sizes</li>
  <li>Wishlist using session/database</li>
  <li>Add to cart, update quantity, remove item</li>
  <li>Customer signup and login</li>
  <li>Customer profile edit</li>
  <li>Password change</li>
  <li>Saved address, phone, and social media/contact link</li>
  <li>Login required before checkout</li>
  <li>Checkout order request system</li>
  <li>My Orders page</li>
</ul>

<h3>🛠 Admin Features</h3>

<ul>
  <li>Admin dashboard statistics</li>
  <li>Admin product add/edit/delete</li>
  <li>Multiple image upload</li>
  <li>Admin category management</li>
  <li>Admin user list</li>
  <li>Admin order management</li>
  <li>Order status management:
    <ul>
      <li>Pending</li>
      <li>Processing</li>
      <li>Delivered</li>
    </ul>
  </li>
  <li>Admin homepage banner management</li>
</ul>

<h3>📄 Additional Pages</h3>

<ul>
  <li>About Page</li>
  <li>Contact Page</li>
  <li>FAQ Page</li>
  <li>Responsive fashion ecommerce styling</li>
</ul>

<hr>

<h2>⚙ Installation Steps</h2>

<h3>1️⃣ Copy Project Folder</h3>

<pre>
C:\xampp\htdocs\alme-pahiran
</pre>

<h3>2️⃣ Start XAMPP Services</h3>

<ul>
  <li>Start Apache</li>
  <li>Start MySQL</li>
</ul>

<h3>3️⃣ Open phpMyAdmin</h3>

<pre>
http://localhost/phpmyadmin
</pre>

<h3>4️⃣ Import Database</h3>

<p>Import the provided <code>database.sql</code> file.</p>

<h3>5️⃣ Configure Database Connection</h3>

<p>Check database settings inside:</p>

<pre>
config/db.php
</pre>

<pre>
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'alme_pahiran';
</pre>

<h3>6️⃣ Open the Website</h3>

<pre>
http://localhost/alme-pahiran/
</pre>

<hr>

<h2>🔐 Admin Login</h2>

<table>
  <tr>
    <th>Field</th>
    <th>Value</th>
  </tr>
  <tr>
    <td>URL</td>
    <td>http://localhost/alme-pahiran/admin/login.php</td>
  </tr>
  <tr>
    <td>Username</td>
    <td>admin</td>
  </tr>
  <tr>
    <td>Password</td>
    <td>admin123</td>
  </tr>
</table>

<hr>

<h2>👤 Sample Customer Login</h2>

<table>
  <tr>
    <th>Field</th>
    <th>Value</th>
  </tr>
  <tr>
    <td>Email</td>
    <td>customer@example.com</td>
  </tr>
  <tr>
    <td>Password</td>
    <td>user123</td>
  </tr>
</table>

<hr>

<h2>🗄 Database Tables</h2>

<ul>
  <li>users</li>
  <li>admins</li>
  <li>categories</li>
  <li>products</li>
  <li>product_images</li>
  <li>cart</li>
  <li>cart_items</li>
  <li>orders</li>
  <li>order_items</li>
  <li>wishlist</li>
  <li>banners</li>
  <li>testimonials</li>
</ul>

<hr>

<h2>📁 Folder Structure</h2>

<pre>
alme-pahiran/
│
├── admin/
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   ├── products.php
│   ├── add_product.php
│   ├── edit_product.php
│   ├── delete_product.php
│   ├── categories.php
│   ├── orders.php
│   ├── update_order.php
│   ├── delete_order.php
│   ├── users.php
│   ├── banners.php
│   └── includes/
│       ├── admin_header.php
│       └── admin_footer.php
│
├── config/
│   ├── db.php
│   ├── init.php
│   └── functions.php
│
├── css/
│   └── style.css
│
├── includes/
│   ├── header.php
│   ├── navbar.php
│   └── footer.php
│
├── uploads/
│   └── products/
│
├── index.php
├── products.php
├── product.php
├── cart.php
├── checkout.php
├── wishlist.php
├── signup.php
├── login.php
├── logout.php
├── profile.php
├── myorders.php
├── about.php
├── contact.php
├── faq.php
├── database.sql
└── README.md
</pre>

<hr>

<h2>👥 Team Responsibilities</h2>

<h3>👨‍💼 SHRESTHA UTTAM (TEAM LEADER)</h3>

<ul>
  <li>index.php</li>
  <li>checkout.php</li>
  <li>database.sql</li>
  <li>config/db.php</li>
  <li>config/init.php</li>
  <li>config/functions.php</li>
  <li>admin/index.php</li>
  <li>admin/dashboard.php</li>
  <li>admin/banners.php</li>
  <li>admin/includes/admin_header.php</li>
  <li>admin/includes/admin_footer.php</li>
  <li>README.md</li>
</ul>

<h3>👩‍💻 THAPA MANISHA</h3>

<ul>
  <li>signup.php</li>
  <li>login.php</li>
  <li>logout.php</li>
  <li>profile.php</li>
  <li>myorders.php</li>
  <li>includes/header.php</li>
  <li>includes/navbar.php</li>
  <li>admin/login.php</li>
  <li>admin/logout.php</li>
  <li>User authentication validation</li>
  <li>Password hashing and password change forms</li>
</ul>

<h3>👨‍💻 SHRESTHA PRAGESH</h3>

<ul>
  <li>products.php</li>
  <li>product.php</li>
  <li>cart.php</li>
  <li>wishlist.php</li>
  <li>admin/products.php</li>
  <li>admin/add_product.php</li>
  <li>admin/edit_product.php</li>
  <li>admin/delete_product.php</li>
  <li>Product search and category filter</li>
  <li>Product image upload logic</li>
</ul>

<h3>👩‍🎨 KHAND THAKURI SHRADDHA</h3>

<ul>
  <li>about.php</li>
  <li>contact.php</li>
  <li>faq.php</li>
  <li>includes/footer.php</li>
  <li>css/style.css</li>
  <li>admin/categories.php</li>
  <li>admin/orders.php</li>
  <li>admin/update_order.php</li>
  <li>admin/delete_order.php</li>
  <li>admin/users.php</li>
  <li>Responsive styling and static content pages</li>
</ul>

<hr>

<h2>📌 Project Note</h2>

<p>
This project was developed as a university group ecommerce project to demonstrate:
</p>

<ul>
  <li>PHP & MySQL CRUD operations</li>
  <li>User authentication system</li>
  <li>Session handling</li>
  <li>Ecommerce workflow implementation</li>
  <li>Admin panel management</li>
  <li>Responsive frontend design using pure CSS</li>
</ul>

<hr>

<h2 align="center">🇳🇵 Thank You for Visiting AlMe Pahiran 🇳🇵</h2>
```
