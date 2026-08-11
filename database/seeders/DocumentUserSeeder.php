<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\User;
class DocumentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@workspace.com',
            'password' => 'admin!@#',
            'role' => 'admin',
        ]);

        $user1 = User::create([
            'name' => 'user one',
            'email' => 'userone@workspace.com',
            'password' => 'userone!@#',
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'user two',
            'email' => 'usertwo@workspace.com',
            'password' => 'usertwo!@#',
            'role' => 'user',
        ]);

        Document::create([
            'user_id' => $admin->id,
            'title' => 'Company Policy',
            'file_path' => 'documents/company-policy.pdf',
        ]);

        Document::create([
            'user_id' => $admin->id,
            'title' => 'Employee Handbook',
            'file_path' => 'documents/employee-handbook.pdf',
        ]);

        Document::create([
            'user_id' => $user1->id,
            'title' => 'Project Requirements',
            'file_path' => 'documents/project-requirements.pdf',
        ]);

        Document::create([
            'user_id' => $user1->id,
            'title' => 'Technical Documentation',
            'file_path' => 'documents/technical-documentation.pdf',
        ]);

        Document::create([
            'user_id' => $user2->id,
            'title' => 'Meeting Notes',
            'file_path' => 'documents/meeting-notes.pdf',
        ]);
    }
}
