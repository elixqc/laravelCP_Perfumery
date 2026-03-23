<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * ProductionDataSeeder
 *
 * Restores all production data after a migrate:fresh.
 * Uses DB::table()->insert() with explicit primary keys so that
 * product_images stay correctly linked to their products (image paths preserved).
 *
 * Run order (called from DatabaseSeeder):
 *   categories → suppliers → users → products → product_images → supply_logs
 */
class ProductionDataSeeder extends Seeder
{
    public function run(): void
    {
        // Disable FK checks so we can insert with explicit IDs freely
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->seedCategories();
        $this->seedSuppliers();
        $this->seedUsers();
        $this->seedProducts();
        $this->seedProductImages();
        $this->seedSupplyLogs();

        // Re-enable FK checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ ProductionDataSeeder finished — all data restored.');
    }

    // -------------------------------------------------------------------------
    // Categories
    // -------------------------------------------------------------------------
    private function seedCategories(): void
    {
        DB::table('categories')->insert([
            ['category_id' => 1, 'category_name' => "Men's Fragrances",   'deleted_at' => null],
            ['category_id' => 2, 'category_name' => "Women's Fragrances", 'deleted_at' => null],
            ['category_id' => 3, 'category_name' => 'Unisex Fragrances',  'deleted_at' => null],
            ['category_id' => 4, 'category_name' => 'niko pogi',          'deleted_at' => '2026-03-21 22:21:48'],
            ['category_id' => 5, 'category_name' => 'EDP',                'deleted_at' => null],
        ]);

        // Advance the auto-increment past inserted IDs
        DB::statement('ALTER TABLE categories AUTO_INCREMENT = 6;');

        $this->command->line('  → categories seeded');
    }

    // -------------------------------------------------------------------------
    // Suppliers
    // -------------------------------------------------------------------------
    private function seedSuppliers(): void
    {
        DB::table('suppliers')->insert([
            [
                'supplier_id'    => 1,
                'supplier_name'  => 'Luxury Scents Inc.',
                'contact_person' => 'Trisha Mia Morales',
                'contact_number' => '+6392752342323',
                'address'        => 'Tagik Cite',
                'is_active'      => 1,
                'deleted_at'     => null,
            ],
            [
                'supplier_id'    => 2,
                'supplier_name'  => 'Aroma Distributors',
                'contact_person' => null,
                'contact_number' => null,
                'address'        => null,
                'is_active'      => 1,
                'deleted_at'     => null,
            ],
            [
                'supplier_id'    => 3,
                'supplier_name'  => 'Fragrantica',
                'contact_person' => 'jaw jiawfj',
                'contact_number' => '09726262789',
                'address'        => 'taguig city 1630',
                'is_active'      => 1,
                'deleted_at'     => null,
            ],
            [
                'supplier_id'    => 6,
                'supplier_name'  => 'ngekngek',
                'contact_person' => 'ngekngek',
                'contact_number' => '0923247266',
                'address'        => 'iawnaindw taguig',
                'is_active'      => 1,
                'deleted_at'     => '2026-03-21 20:00:39',
            ],
        ]);

        DB::statement('ALTER TABLE suppliers AUTO_INCREMENT = 7;');

        $this->command->line('  → suppliers seeded');
    }

    // -------------------------------------------------------------------------
    // Users  (real accounts + factory-generated ones)
    // -------------------------------------------------------------------------
    private function seedUsers(): void
    {
        DB::table('users')->insert([
            // --- Admin & seeded accounts ---
            [
                'user_id'           => 1,
                'username'          => 'admin',
                'full_name'         => 'Admin User',
                'contact_number'    => null,
                'address'           => 'nice',
                'profile_picture'   => null,
                'email'             => 'admin@example.com',
                'email_verified_at' => '2026-03-06 17:17:28',
                'password'          => '$2y$12$Ae5kQm6EpHTUVE5UjTuB/.ykKHgMllTiz9ywehBTcy22Q3GiZXHRO',
                'remember_token'    => null,
                'role'              => 'admin',
                'is_active'         => 1,
                'created_at'        => '2026-03-06 17:17:28',
                'updated_at'        => '2026-03-06 17:17:28',
            ],
            [
                'user_id'           => 2,
                'username'          => 'customer',
                'full_name'         => 'Customer User',
                'contact_number'    => null,
                'address'           => null,
                'profile_picture'   => null,
                'email'             => 'customer@example.com',
                'email_verified_at' => null,
                'password'          => '$2y$12$Oc7g7OwAOmrqNRrdbN.RyOG6TCIvklD2Hsro3dGS6CmvZp1AfmU22',
                'remember_token'    => null,
                'role'              => 'customer',
                'is_active'         => 1,
                'created_at'        => null,
                'updated_at'        => null,
            ],
            // --- Real registered customers ---
            [
                'user_id'           => 3,
                'username'          => 'elixqc',
                'full_name'         => 'nico barredo',
                'contact_number'    => '09392891165',
                'address'           => '291 zamora st. brgy pinagsama taguig city 1630',
                'profile_picture'   => 'profile_pictures/JVxDnFI93u4fDI1zavql2JQHOPBX6yCVrbpHK9B7.jpg',
                'email'             => 'nicobarredo87@gmail.com',
                'email_verified_at' => '2026-03-06 18:12:53',
                'password'          => '$2y$12$KpArMlUJvuIyZUSSCfqCGO5LlsdPFaOH.sc2UmEUnfbLDOsemMV2K',
                'remember_token'    => 'I3xcrbIw3SWjQQTeXhfCAUVOV7bvjXTy22gDthVy4YdSQFNaGzzdEjUd7ujr',
                'role'              => 'customer',
                'is_active'         => 1,
                'created_at'        => null,
                'updated_at'        => '2026-03-21 20:33:18',
            ],
            [
                'user_id'           => 6,
                'username'          => 'elixqc1',
                'full_name'         => 'nico barredo',
                'contact_number'    => null,
                'address'           => null,
                'profile_picture'   => null,
                'email'             => 'nico.barredo@tup.edu.ph',
                'email_verified_at' => '2026-03-06 18:28:09',
                'password'          => '$2y$12$swYuJCqIMqJr9YU17EFrtutzzSsaECuE77pyBM3wGD3NZIqCu6ao2',
                'remember_token'    => null,
                'role'              => 'customer',
                'is_active'         => 1,
                'created_at'        => '2026-03-06 18:27:48',
                'updated_at'        => '2026-03-06 18:28:09',
            ],
            [
                'user_id'           => 7,
                'username'          => 'elixqc12',
                'full_name'         => 'nico barredo',
                'contact_number'    => '09930536452',
                'address'           => 'taguig city',
                'profile_picture'   => 'profile_pictures/m08BJ6Lar4fT1ymZXExcJzofHpZlaUckxxL0Gn2R.jpg',
                'email'             => 'spotifymod1020@gmail.com',
                'email_verified_at' => '2026-03-06 18:43:07',
                'password'          => '$2y$12$VZXBCJZiCqjSf51DApOtPuNTJN0Jkky9vAJ3ZE7zDAerUi5Lv9ARC',
                'remember_token'    => null,
                'role'              => 'customer',
                'is_active'         => 1,
                'created_at'        => '2026-03-06 18:42:48',
                'updated_at'        => '2026-03-06 19:37:10',
            ],
            // --- Factory-generated users (batch from UserSeeder) ---
            ['user_id' => 8,  'username' => 'considine.henry', 'full_name' => 'Lorna Schamberger',      'contact_number' => '+14588076592',    'address' => '22893 Adelle Junction\nMyleneville, IN 85339',                  'profile_picture' => null, 'email' => 'christiansen.river@example.com', 'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'Wbaq1VH26e', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 9,  'username' => 'harber.leif',     'full_name' => 'Felicia Connelly',       'contact_number' => '1-667-537-5102',  'address' => '66925 Grimes Ports Suite 591\nWhitefort, IL 37570-8316',       'profile_picture' => null, 'email' => 'mustafa38@example.net',          'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'avE85RGbtF', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 10, 'username' => 'witting.edison',  'full_name' => 'Ines Jaskolski',         'contact_number' => '(586) 596-5529',  'address' => '60679 Borer Pine\nAldashire, KY 96453',                        'profile_picture' => null, 'email' => 'bschaefer@example.net',          'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'j69Xq3H3Lv', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 11, 'username' => 'kellie.purdy',    'full_name' => 'Prof. Nannie Skiles',    'contact_number' => '1-442-735-7507',  'address' => '17683 Ernie Valley Apt. 350\nChanelland, KY 96297',            'profile_picture' => null, 'email' => 'filiberto59@example.com',        'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'mEyzShH1iA', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 12, 'username' => 'emiliano50',      'full_name' => 'Fred Gottlieb DVM',      'contact_number' => '+1-463-890-8848', 'address' => '7138 Alberta Freeway\nMullerton, RI 16271',                    'profile_picture' => null, 'email' => 'mayer.ashlee@example.org',       'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'Nxy2vzTUb1', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 13, 'username' => 'donny82',         'full_name' => 'Abel Beier',             'contact_number' => '+19388295504',    'address' => '9710 Bartoletti Street Suite 116\nNew Marlinton, IN 39300',    'profile_picture' => null, 'email' => 'kadin.marquardt@example.com',    'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'DKneoVsDEk', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 14, 'username' => 'isabel71',        'full_name' => 'Eloy Moen',              'contact_number' => '(220) 472-9214',  'address' => '284 Hills Dam Apt. 615\nPort Berta, DC 19295-2352',            'profile_picture' => null, 'email' => 'ehahn@example.net',              'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'K29WeTLDQd', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 15, 'username' => 'aschiller',       'full_name' => 'Ms. Jannie Connelly PhD','contact_number' => '(832) 540-3489',  'address' => '865 Davis Keys Apt. 668\nRaquelland, WY 02144-1598',          'profile_picture' => null, 'email' => 'bbins@example.com',              'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'hV1wb1Dwrq', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 16, 'username' => 'sbrown',          'full_name' => 'Raul Lebsack',           'contact_number' => '920-758-9662',    'address' => '56810 Tatum Valleys\nPort Fosterfurt, NH 32996',               'profile_picture' => null, 'email' => 'fahey.abdul@example.com',        'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'KbLIhdLvmY', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 17, 'username' => 'akuhn',           'full_name' => 'Gilda Hegmann II',       'contact_number' => '1-682-602-4165',  'address' => '74962 Upton Fort Suite 021\nWest Heavenfurt, KS 23631-0323',  'profile_picture' => null, 'email' => 'apollich@example.org',           'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'CIDODkDDUa', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 18, 'username' => 'bret94',          'full_name' => 'Mrs. Ardella Dooley',    'contact_number' => '+1-541-851-8147', 'address' => '40293 Nicolas Terrace\nMuhammadside, MI 80256',                'profile_picture' => null, 'email' => 'arnoldo.mraz@example.net',       'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'KK7c6o9RnO', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 19, 'username' => 'zhill',           'full_name' => 'Louie Dickinson',        'contact_number' => '(248) 302-9986',  'address' => '2922 McCullough Springs Apt. 937\nWest Heatherfort, TX 54880-5374', 'profile_picture' => null, 'email' => 'wgoldner@example.org',      'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'VhjkjAtK0p', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 20, 'username' => 'marilie.lebsack', 'full_name' => 'Israel Kuvalis III',     'contact_number' => '423-537-5882',    'address' => '3586 Watsica Fork\nFeeneyfort, ID 84186',                     'profile_picture' => null, 'email' => 'peyton73@example.com',           'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'wpCpbCzlwH', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 21, 'username' => 'walker.maynard',  'full_name' => 'Miss Lexie Smitham',     'contact_number' => '1-412-678-9104',  'address' => '189 Nicolas Alley\nGennarostad, NY 08762',                    'profile_picture' => null, 'email' => 'lucius37@example.org',           'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => '0QJQ7zb1wz', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 22, 'username' => 'phahn',           'full_name' => 'Sonny Marquardt',        'contact_number' => '+1 (682) 362-4085','address' => '4341 Clementine Drives Suite 370\nSouth Jerrod, SD 62586',    'profile_picture' => null, 'email' => 'alysha83@example.org',           'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'Oyz42hoewt', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 23, 'username' => 'greichel',        'full_name' => 'Alexys Nitzsche',        'contact_number' => '1-678-882-3443',  'address' => '80637 Hauck Cove Suite 584\nLake Jack, NE 98991',              'profile_picture' => null, 'email' => 'howard.erdman@example.org',      'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'zUicPqV5CJ', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 24, 'username' => 'walker.reanna',   'full_name' => 'Dr. Ena Smith Sr.',      'contact_number' => '848.673.1830',    'address' => '11430 Eleazar Walk\nAnnabelfurt, WV 04208',                   'profile_picture' => null, 'email' => 'keon12@example.org',             'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'jhyPiN1E6l', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 25, 'username' => 'eli96',           'full_name' => 'Reggie Morissette I',    'contact_number' => '+1-607-478-3481', 'address' => '58537 Filomena Pass\nWest Lucasberg, CT 64456-2170',          'profile_picture' => null, 'email' => 'santina84@example.org',          'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'MDzJbkz22S', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 26, 'username' => 'uconsidine',      'full_name' => 'Juliet Kling',           'contact_number' => '+19518282729',    'address' => '3138 Velda Turnpike Apt. 120\nArmandmouth, WA 93112-2372',    'profile_picture' => null, 'email' => 'ekoelpin@example.org',           'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => '5PpwUldHgw', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            ['user_id' => 27, 'username' => 'gleason.modesto', 'full_name' => 'Mrs. Brielle DuBuque III','contact_number' => '(715) 858-8755', 'address' => '974 Schultz Village Suite 535\nPort Edmond, AK 78055',         'profile_picture' => null, 'email' => 'ncrona@example.com',             'email_verified_at' => '2026-03-07 04:43:04', 'password' => '$2y$12$6RfAFen4VASfVe3nwVp5w.YVGlvHjMnxiKJJp0JAuA/QmI0VK6ypS', 'remember_token' => 'gZVdas7RmB', 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-07 04:43:04', 'updated_at' => '2026-03-07 04:43:04'],
            // --- Late registrations ---
            ['user_id' => 30, 'username' => 'awawaw1',      'full_name' => 'awaw awffawfn',  'contact_number' => '0293204874',    'address' => 'seknfs',        'profile_picture' => null,                                                       'email' => 'josephlorenzcoronado@gmail.com', 'email_verified_at' => '2026-03-12 18:29:05', 'password' => '$2y$12$rno7T4o3.qfA2tcbxm/R0u4aAh15vaj5dQPowAi56HXv8/iXBFZyO', 'remember_token' => null, 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-12 18:28:15', 'updated_at' => '2026-03-21 07:47:45'],
            ['user_id' => 31, 'username' => 'samplesample', 'full_name' => 'samplesample',   'contact_number' => '2032932674',    'address' => 'einfsnefnke tcity', 'profile_picture' => 'profile_pictures/hYvkG79wr6xfjzhBJ5e79QWndq5t0bZz3d0Chslm.jpg', 'email' => 'perfumeryprestige@gmail.com', 'email_verified_at' => '2026-03-20 04:29:42', 'password' => '$2y$12$anr.fMkpOLdFON719le.JOXq6G4SPqH99hMv2HpDczzTCWcdZEa7y', 'remember_token' => null, 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-20 04:29:30', 'updated_at' => '2026-03-21 03:16:28'],
            ['user_id' => 32, 'username' => 'mawmawmaw',   'full_name' => 'maw maw',        'contact_number' => '093427482463',  'address' => 'taguig city',   'profile_picture' => null,                                                       'email' => 'mawmaw@gmail.com',              'email_verified_at' => '2026-03-20 18:46:07', 'password' => '$2y$12$SRCR6Cg2R56jQ9kDJzevQ.ehQkQqPs0ZAhL5Kj3rhYcZnSnOCs5iS', 'remember_token' => null, 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-20 18:45:54', 'updated_at' => '2026-03-20 18:46:07'],
            ['user_id' => 33, 'username' => 'ewan',        'full_name' => 'ewan ewan',       'contact_number' => '09722462742',   'address' => 'taguig city',   'profile_picture' => null,                                                       'email' => 'ewan@gmail.om',                 'email_verified_at' => null,                  'password' => '$2y$12$MivNibjDL/uMNukmMHisFu8/CprCBmTsiRYS83MLt6d8HxT9J4AjG', 'remember_token' => null, 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-21 19:33:38', 'updated_at' => '2026-03-21 19:33:38'],
            ['user_id' => 34, 'username' => 'ewan1',       'full_name' => 'ewan ewan',       'contact_number' => '+639224324324', 'address' => 'TAGUIG',        'profile_picture' => 'profile_pictures/8KljDxtcVGeSiptyK043kl0fZ6Sstkhwhvw6R4Kq.png', 'email' => 'ewan@gmail.com',            'email_verified_at' => '2026-03-21 19:37:12', 'password' => '$2y$12$vrUYkzcVCCXC4yM5Ro2opeZb4egbTjw3go.2eVOuyY7ttMSfL59l.', 'remember_token' => null, 'role' => 'customer', 'is_active' => 1, 'created_at' => '2026-03-21 19:36:31', 'updated_at' => '2026-03-21 19:38:53'],
        ]);

        DB::statement('ALTER TABLE users AUTO_INCREMENT = 35;');

        $this->command->line('  → users seeded');
    }

    // -------------------------------------------------------------------------
    // Products  (explicit IDs preserve FK links with product_images)
    // -------------------------------------------------------------------------
    private function seedProducts(): void
    {
        DB::table('products')->insert([
            ['product_id' => 5,  'product_name' => 'Quartus',             'description' => 'Quartus is a fresh yet slightly woody fragrance that combines crisp notes with a gentle musky base. It gives off a clean, relaxed vibe that is both approachable and subtly refined.',                                                                                                                                                     'category_id' => 1, 'supplier_id' => 1, 'initial_price' => 2500.00, 'selling_price' => 3000.00,  'stock_quantity' => 9,   'variant' => '50ml',  'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 6,  'product_name' => 'Quintus',             'description' => 'Quintus is a rich, sophisticated fragrance featuring deep woods, amber, and a touch of sweetness. It delivers a warm, luxurious aura that feels confident, mature, and long-lasting.',                                                                                                                                                        'category_id' => 1, 'supplier_id' => 1, 'initial_price' => 4000.00, 'selling_price' => 4500.00,  'stock_quantity' => 48,  'variant' => '100ml', 'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 7,  'product_name' => 'Sucundus',            'description' => 'Sucundus is a balanced and refined fragrance that blends fresh citrus with soft woods and subtle spices. It offers a smooth, versatile scent that feels modern, clean, and effortlessly elegant.',                                                                                                                                            'category_id' => 3, 'supplier_id' => 1, 'initial_price' => 5600.00, 'selling_price' => 7000.00,  'stock_quantity' => 47,  'variant' => '50ml',  'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 8,  'product_name' => 'Fire',                'description' => 'Fire is a bold, intense scent profile built around warm spices, smoky accords, and burning woods. It feels powerful and energetic, leaving a fiery, captivating trail that commands attention.',                                                                                                                                              'category_id' => 1, 'supplier_id' => 1, 'initial_price' => 300.00,  'selling_price' => 3050.00,  'stock_quantity' => 49,  'variant' => '100ml', 'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 9,  'product_name' => 'Elixir',              'description' => 'Elixir is a rich, concentrated fragrance style known for its deep, intense blend of sweet, spicy, and woody notes. It feels bold and long-lasting, often leaving a warm, seductive trail with a luxurious, almost syrupy depth.',                                                                                                            'category_id' => 3, 'supplier_id' => 2, 'initial_price' => 900.00,  'selling_price' => 1000.00,  'stock_quantity' => 50,  'variant' => '50ml',  'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 10, 'product_name' => 'Naxos',               'description' => 'Naxos is a warm, aromatic fragrance that blends honey, tobacco, and vanilla with fresh citrus and lavender for a rich yet smooth scent. It delivers a luxurious, slightly sweet and spicy profile that feels both elegant and comforting.',                                                                                                   'category_id' => 1, 'supplier_id' => 1, 'initial_price' => 9000.00, 'selling_price' => 10000.00, 'stock_quantity' => 10,  'variant' => '50ml',  'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 11, 'product_name' => 'Masc',                'description' => 'Masc is a bold, masculine fragrance profile characterized by strong woody, spicy, and musky notes that create a confident and powerful scent. It often feels warm, deep, and long-lasting, giving off a rugged yet refined vibe.',                                                                                                            'category_id' => 3, 'supplier_id' => 1, 'initial_price' => 9000.00, 'selling_price' => 10500.00, 'stock_quantity' => 49,  'variant' => '100ml', 'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 12, 'product_name' => 'White',               'description' => 'White is a light, clean fragrance profile often associated with fresh florals, soft musk, and powdery notes that create a pure and airy scent. It gives off a subtle, elegant vibe that feels calm, refined, and effortlessly fresh.',                                                                                                       'category_id' => 2, 'supplier_id' => 1, 'initial_price' => 900.00,  'selling_price' => 1100.00,  'stock_quantity' => 100, 'variant' => '50ml',  'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 13, 'product_name' => 'Initio',              'description' => 'Initio is a luxury fragrance house known for its bold, sensual compositions that blend powerful ingredients like oud, musk, and spices into captivating scents. Its perfumes are designed to evoke emotion and attraction, often delivering long-lasting, intense, and mysterious olfactory experiences.',                                     'category_id' => 2, 'supplier_id' => 2, 'initial_price' => 4000.00, 'selling_price' => 5500.00,  'stock_quantity' => 99,  'variant' => '50ml',  'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 14, 'product_name' => 'Ice',                 'description' => 'Ice is a fresh, clean scent profile that captures the feeling of coolness and clarity, often featuring notes like mint, citrus, and aquatic accords. It gives off a crisp, energizing vibe that feels refreshing and modern, perfect for everyday wear.',                                                                                    'category_id' => 2, 'supplier_id' => 1, 'initial_price' => 7000.00, 'selling_price' => 9000.00,  'stock_quantity' => 3,   'variant' => '50ml',  'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 15, 'product_name' => 'aa',                  'description' => 'asdwadsawssd',                                                                                                                                                                                                                                                                                                                               'category_id' => 3, 'supplier_id' => 1, 'initial_price' => 2000.00, 'selling_price' => 4500.00,  'stock_quantity' => 10,  'variant' => '50ml',  'is_active' => 1, 'deleted_at' => '2026-03-18 20:24:53'],
            ['product_id' => 16, 'product_name' => 'sample1',             'description' => 'awdadnwaawdaawd',                                                                                                                                                                                                                                                                                                                             'category_id' => 1, 'supplier_id' => 2, 'initial_price' => 50.00,   'selling_price' => 100.00,   'stock_quantity' => 15,  'variant' => '50ml',  'is_active' => 1, 'deleted_at' => '2026-03-20 19:07:13'],
            ['product_id' => 17, 'product_name' => 'sample2',             'description' => null,                                                                                                                                                                                                                                                                                                                                          'category_id' => null, 'supplier_id' => null, 'initial_price' => null, 'selling_price' => null, 'stock_quantity' => 10,  'variant' => null,    'is_active' => 1, 'deleted_at' => '2026-03-21 03:27:07'],
            ['product_id' => 18, 'product_name' => 'Byredo',              'description' => 'a hauntingly graceful composition that captures the resilient beauty of the xeric flower blooming in the arid desert. The scent opens with a transparent sweetness of ambrette and fresh sapodilla, eventually settling into a sophisticated, powdery finish of sandalwood and crisp amber.',                                                 'category_id' => 3, 'supplier_id' => 2, 'initial_price' => 7000.00, 'selling_price' => 8000.00,  'stock_quantity' => 10,  'variant' => '100ml', 'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 19, 'product_name' => 'Oud Royale Intense',  'description' => 'Oud Royal Intense is a rich, woody-amber fragrance built around deep oud, blended with warm spices, rose, and smoky incense for a bold and luxurious scent. It leaves a long-lasting, sensual trail of amber, sandalwood, and musk that feels both elegant and mysterious.',                                                                'category_id' => 1, 'supplier_id' => 3, 'initial_price' => 9000.00, 'selling_price' => 10000.00, 'stock_quantity' => 25,  'variant' => '50ml',  'is_active' => 1, 'deleted_at' => null],
            ['product_id' => 20, 'product_name' => 'category testing delete', 'description' => 'awdafmwfiwfni',                                                                                                                                                                                                                                                                                                                          'category_id' => 4, 'supplier_id' => 6, 'initial_price' => 50.00,   'selling_price' => 100.00,   'stock_quantity' => 10,  'variant' => '50ML',  'is_active' => 0, 'deleted_at' => '2026-03-21 20:32:13'],
        ]);

        DB::statement('ALTER TABLE products AUTO_INCREMENT = 21;');

        $this->command->line('  → products seeded');
    }

    // -------------------------------------------------------------------------
    // Product images  ← this is the data that MUST survive after migrate:fresh
    // -------------------------------------------------------------------------
    private function seedProductImages(): void
    {
        DB::table('product_images')->insert([
            ['image_id' => 7,  'product_id' => 5,  'image_path' => 'products/72FiGYjg9ecLyMajybvgaDTclMi1el2dcjVoAzZS.png', 'uploaded_at' => '2026-03-06 06:18:25'],
            ['image_id' => 18, 'product_id' => 15, 'image_path' => 'products/oQa4sjdQzRyioHg1UBJy8WKTOsLToHuiJjgogNJN.png', 'uploaded_at' => '2026-03-07 04:19:16'],
            ['image_id' => 19, 'product_id' => 15, 'image_path' => 'products/QPPOKHqzzMkGxcBeJ30ZGrYqSCwLRVp9vHkswiO6.png', 'uploaded_at' => '2026-03-07 04:19:39'],
            ['image_id' => 20, 'product_id' => 15, 'image_path' => 'products/bXwXUo95fizhjolK0V9J1FPsqcTQvjYyUWQvDTXt.png', 'uploaded_at' => '2026-03-07 04:19:40'],
            ['image_id' => 21, 'product_id' => 6,  'image_path' => 'products/03BjD1flpgwgL40WmQsJr7g51zc2v2OK4ZwInKsr.png', 'uploaded_at' => '2026-03-07 04:29:14'],
            ['image_id' => 22, 'product_id' => 7,  'image_path' => 'products/I7eT2ZVavd4R41fS19UoJML0PlTAGC1Zvtr1SLY0.png', 'uploaded_at' => '2026-03-07 04:30:23'],
            ['image_id' => 23, 'product_id' => 8,  'image_path' => 'products/htIm52oXfun6kmQ8W4tMdlicPKZQOnjZicKf2z1L.png', 'uploaded_at' => '2026-03-07 04:31:21'],
            ['image_id' => 24, 'product_id' => 8,  'image_path' => 'products/2wUqUfMAbeJNDq8ECBYWigcdoCmPJ3iNNjh4kthY.png', 'uploaded_at' => '2026-03-07 04:31:21'],
            ['image_id' => 25, 'product_id' => 8,  'image_path' => 'products/pz5v2Ep3V2rPgY62lJqq8t9SwN1RSlKrMmcQkQU0.png', 'uploaded_at' => '2026-03-07 04:31:21'],
            ['image_id' => 26, 'product_id' => 9,  'image_path' => 'products/Qxy7bVCLkpTdXQwA0Hx9L5Wc87xYMs89Ra0eAmbb.png', 'uploaded_at' => '2026-03-07 04:31:57'],
            ['image_id' => 27, 'product_id' => 10, 'image_path' => 'products/fS2zthplKN7ZDym0QoApGEJmSh7J4Ue2OqQsulv3.png', 'uploaded_at' => '2026-03-07 04:32:33'],
            ['image_id' => 28, 'product_id' => 10, 'image_path' => 'products/mcdfMzpeDY2E6xbLmX9n9AK8oxhycfee1RUYxQFe.png', 'uploaded_at' => '2026-03-07 04:32:33'],
            ['image_id' => 29, 'product_id' => 10, 'image_path' => 'products/2fJBi2PG6N8dSk9Nwz13Y9YNNQoxfdx2DezsUezK.png', 'uploaded_at' => '2026-03-07 04:32:33'],
            ['image_id' => 30, 'product_id' => 11, 'image_path' => 'products/RN5C6GE606F0PqaSTjvxvntvKbb5vGwZdvIlAJYv.png', 'uploaded_at' => '2026-03-07 04:33:10'],
            ['image_id' => 31, 'product_id' => 11, 'image_path' => 'products/LGPMZh8Dk2UcnSQmAshzd465hGeY9sIFC4QEDV6n.png', 'uploaded_at' => '2026-03-07 04:33:10'],
            ['image_id' => 32, 'product_id' => 11, 'image_path' => 'products/keSbdOaonAT9jSuZGMxuJswJrbd6dfOrWE5kXbGl.png', 'uploaded_at' => '2026-03-07 04:33:10'],
            ['image_id' => 33, 'product_id' => 12, 'image_path' => 'products/ZtRrn81XRxTmKyxL3QtPtin5vBfUBR7jsRQOmVFI.jpg', 'uploaded_at' => '2026-03-07 16:36:35'],
            ['image_id' => 34, 'product_id' => 13, 'image_path' => 'products/1iPBryWG53rZwSxnsfompfoPguwEhFHRT4Vt65pq.png', 'uploaded_at' => '2026-03-07 16:37:27'],
            ['image_id' => 36, 'product_id' => 14, 'image_path' => 'products/wScoDpPZuDyug2rpxnUnuZX7Jdp54NmSzoGoWUUw.png', 'uploaded_at' => '2026-03-07 16:38:45'],
            ['image_id' => 37, 'product_id' => 14, 'image_path' => 'products/CZy0t7h4kdiVoWey3QhRQPGhuFsnyS2qIN72ifgx.jpg', 'uploaded_at' => '2026-03-19 17:12:49'],
            ['image_id' => 38, 'product_id' => 16, 'image_path' => 'products/dMXdFiuOtggSdbTC912O5iOAmqJWwKyaSVrGpUDP.jpg', 'uploaded_at' => '2026-03-20 03:02:35'],
            ['image_id' => 41, 'product_id' => 16, 'image_path' => 'products/JGvpSdp0ERnL3Yu6wMjIeC4rX4Ka4mkGIUVfStBk.png', 'uploaded_at' => '2026-03-20 03:17:40'],
            ['image_id' => 42, 'product_id' => 19, 'image_path' => 'products/Q7m4HDVGoDZdWsqzN3BFDXPPQGC9A9yeW2HFMYO9.png', 'uploaded_at' => '2026-03-20 03:52:48'],
            ['image_id' => 44, 'product_id' => 19, 'image_path' => 'products/d7ZX1lrEKNg7l670SHZsTfLcdOzYQP9scGvUo4fC.png', 'uploaded_at' => '2026-03-20 03:52:48'],
            ['image_id' => 45, 'product_id' => 18, 'image_path' => 'products/h2sy4vtfEqcTclYhMf9JNYDnuXZyPDp3jClKS8DC.png', 'uploaded_at' => '2026-03-20 19:28:22'],
            ['image_id' => 46, 'product_id' => 20, 'image_path' => 'products/n86xjEnqCY8cx5ymzIGdB2p7yIxbHomYCuz0yRCQ.png', 'uploaded_at' => '2026-03-21 04:25:22'],
            ['image_id' => 48, 'product_id' => 19, 'image_path' => 'products/5JRpdGeLAVBOmvwkNQ5WlyxQuxd9pNbjpObn2iMl.png', 'uploaded_at' => '2026-03-21 04:30:05'],
        ]);

        DB::statement('ALTER TABLE product_images AUTO_INCREMENT = 50;');

        $this->command->line('  → product_images seeded (image paths restored ✅)');
    }

    // -------------------------------------------------------------------------
    // Supply logs
    // -------------------------------------------------------------------------
    private function seedSupplyLogs(): void
    {
        DB::table('supply_logs')->insert([
            ['supply_id' => 1, 'product_id' => 16, 'supplier_id' => 2, 'quantity_added' => 5,  'supplier_price' => 50.00,   'supply_date' => '2026-03-20 11:49:27', 'remarks' => 'Stock increased via product update'],
            ['supply_id' => 2, 'product_id' => 19, 'supplier_id' => 3, 'quantity_added' => 10, 'supplier_price' => 400.00,  'supply_date' => '2026-03-20 11:52:48', 'remarks' => 'Initial stock on product creation'],
            ['supply_id' => 3, 'product_id' => 19, 'supplier_id' => 3, 'quantity_added' => 3,  'supplier_price' => 9000.00, 'supply_date' => '2026-03-21 02:34:04', 'remarks' => 'Stock increased via product update'],
            ['supply_id' => 4, 'product_id' => 20, 'supplier_id' => 6, 'quantity_added' => 10, 'supplier_price' => 50.00,   'supply_date' => '2026-03-21 12:25:22', 'remarks' => 'Initial stock on product creation'],
            ['supply_id' => 5, 'product_id' => 19, 'supplier_id' => 3, 'quantity_added' => 10, 'supplier_price' => 9000.00, 'supply_date' => '2026-03-22 04:06:29', 'remarks' => 'Stock increased via product update'],
            ['supply_id' => 6, 'product_id' => 19, 'supplier_id' => 3, 'quantity_added' => 4,  'supplier_price' => 9000.00, 'supply_date' => '2026-03-22 04:06:40', 'remarks' => 'Stock increased via product update'],
            ['supply_id' => 7, 'product_id' => 18, 'supplier_id' => 2, 'quantity_added' => 10, 'supplier_price' => 7000.00, 'supply_date' => '2026-03-22 04:41:41', 'remarks' => 'Stock increased via product update'],
        ]);

        DB::statement('ALTER TABLE supply_logs AUTO_INCREMENT = 8;');

        $this->command->line('  → supply_logs seeded');
    }
}