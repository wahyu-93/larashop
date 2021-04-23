<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new User;
        $administrator->username = "administrator";
        $administrator->name     = "Site Administrator";
        $administrator->email    = "administrator@larashop.test";
        $administrator->roles    = json_encode(["ADMIN"]);
        $administrator->password = Hash::make("larashop");
        $administrator->avatar   = "saat-ini-tidak-ada-file.png";
        $administrator->address  = "Sarmil, bintari, tangerang selatan";
        $administrator->phone    = "082353089050";
        $administrator->save();

        $this->command->info("User Admin berhasil diinsert");
    }
}
