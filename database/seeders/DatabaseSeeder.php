<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'username' => 'admin',
            'password' => md5(md5('admin')),
            'token' => '',
            'timeout' => date('Y-m-d H:i:s'),
            'address' => 'Hà Tĩnh',
            'email' => 's2attack2s@gmail.com',
            'phone' => '0818618767',
            'updated_by' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('profile')->insert(
            [
                [
                    'id' => 1,
                    'language_id' => 1,
                    'name' => 'Nguyễn Trọng Sơn',
                    'image' => './images/home/image-profile.jpg',
                    'position' => 'fresher php (Laravel)',
                    'birthday' => '2000/05/26',
                    'sex' => 'Nam',
                    'address' => 'Tân Lộc - Lộc Hà - Hà Tĩnh',
                    'email' => 'ntson12a4@gmail.com',
                    'phone' => '0818618767',
                    'website' => 'https://www.facebook.com/sonnguyen2605',
                    'updated_by' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'language_id' => 2,
                    'name' => 'Nguyen Trong Son',
                    'image' => './images/home/image-profile.jpg',
                    'position' => 'fresher php (Laravel)',
                    'birthday' => '2000/05/26',
                    'sex' => 'Male',
                    'address' => 'Tan Loc - Loc Ha - Ha Tinh',
                    'email' => 'ntson12a4@gmail.com',
                    'phone' => '0818618767',
                    'website' => 'https://www.facebook.com/sonnguyen2605',
                    'updated_by' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ]
        );

        DB::table('objective')->insert(
            [
                [
                    'id' => 1,
                    'language_id' => 1,
                    'text' => '
                <p>- Ngắn hạn :</br>
                     + Được làm việc ở vị trí PHP developer và làm quen tốt với môi trường làm việc ở công ty.</br>
                   - Dài hạn :</br>
                    + Sử dụng kiến thức được đào tạo mang lại kết quả tốt cho công ty</br>
                    + Thăng tiến trở thành Senior PHP.</br>
                    + Gắn bó lâu dài với công ty để có có hội trở thành 1 Team Leader</br>
                </p>',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'language_id' => 2,
                    'text' => "
                <p>- Short-Term:</br>
                     + Work as a PHP developer and get familiar with the company's working environment.</br>
                   - Long-Term:</br>
                    + Using training knowledge brings good results for the company</br>
                    + Advance to Senior PHP.</br>
                    + Stick with the company for a long time to have the opportunity to become a Team Leader</br>
            </p>",
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ]
        );

        DB::table('education')->insert(
            [
                [
                    'id' => 1,
                    'language_id' => 1,
                    'title' => 'Cao đẳng FPT Polytechnic',
                    'text' => '
                <p>Chuyên ngành: Công nghệ thông tin </br>
                     - Xếp loại : Khá (7.7) </br>
                </p>',
                    'start_at' => '2018/08/15',
                    'finish_at' => '2021/01/15',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'language_id' => 2,
                    'title' => 'FPT Polytechnic College',
                    'text' => '
                <p>Specialized: Information Technology </br>
                  - Rank : Good (7.7) </br>
                 </p>',
                    'start_at' => '2018/08/15',
                    'finish_at' => '2021/01/15',
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ]

        );
        DB::table('work-ep')->insert(
            [
                [
                    'id' => 1,
                    'language_id' => 1,
                    'title' => 'TRANG WEB TUYỂN DỤNG(A.N.S ASIA)',
                    'position' => 'Vị trí : Fresher Developer',
                    'text' => '
        <p>
        * Công việc trong dự án :</br>
        + Xây dựng giao diện</br>
        + Xây dựng chức năng</br>
        + Tối ưu code</br>
        * Công nghệ sử dụng</br>
        + Sử dụng Git, Docker, My Sql, Visual Studio Code</br>
        + Framework Laravel, Ajax, Bootstrap, slick, Jquery, Html, CSS, Js.</br>
     </p>
        ',
                    'start_at' => '2021/07/07',
                    'finish_at' => '2021/08/15',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'language_id' => 1,
                    'title' => 'Trang web giới thiệu công ty (A.N.S ASIA)',
                    'position' => 'Vị trí : Fresher Developer',
                    'text' => '
        <p>
        * Công việc trong dự án :</br>
        + Xây dựng giao diện</br>
        + Xây dựng chức năng</br>
        + Tối ưu code</br>
        * Công nghệ sử dụng</br>
        + Sử dụng Git, Docker, My Sql, Visual Studio Code</br>
        + Framework Laravel, Ajax, Bootstrap, slick, Jquery, Html, CSS, Js.</br>
     </p>
        ',
                    'start_at' => '2021/06/01',
                    'finish_at' => '2021/07/06',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 3,
                    'language_id' => 1,
                    'title' => 'Dự án thực tập sinh',
                    'position' => 'Vị trí : Intern Developer',
                    'text' => '
        <p>
        * Công việc trong dự án :</br>
        + Xây dựng giao diện</br>
        + Xây dựng chức năng</br>
        * Công nghệ sử dụng</br>
        + Sử dụng Git, Docker, My Sql, Visual Studio Code</br>
        + Framework Laravel, Ajax, Bootstrap, Jquery, Html, CSS, Js.</br>
     </p>
        ',
                    'start_at' => '2021/04/01',
                    'finish_at' => '2021/05/28',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 4,
                    'language_id' => 1,
                    'title' => 'TRANG WEB BÁN HÀNG BẰNG NODEJS',
                    'position' => '<span class="pc">
        (Dự án cá nhân: </br>
        Link github: <a href="https://github.com/s2attack2s/sonnt_webbanhang">https://github.com/s2attack2s/sonnt_webbanhang</a>
        </br>
        Link demo: <a href="https://web-sonnt.herokuapp.com/">https://web-sonnt.herokuapp.com/</a>
        )</span>
     <span class="mobile">
        (Dự án cá nhân: </br>
        Link github: <a href="https://github.com/s2attack2s/sonnt_webbanhang">https://bitly.com.vn/fwcjey</a>
        </br>
        Link demo: <a href="https://web-sonnt.herokuapp.com/">https://bitly.com.vn/rbkt6j</a>
        )</span>',
                    'text' => '
        <p>
        * Công việc trong dự án :</br>
        + Phân tích dữ liệu</br>
        + Thiết kế UI/UX</br>
        + Xây dựng chức năng</br>
        * Công nghệ sử dụng</br>
        + Sử dụng Git, MongoDB, Visual Studio Code</br>
        + Framework Express, Bootstrap, Html, CSS, Js.</br>
     </p>
        ',
                    'start_at' => '2020/10/01',
                    'finish_at' => '2020/11/15',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 5,
                    'language_id' => 2,
                    'title' => 'RECRUITMENT PAGE(A.N.S ASIA)',
                    'position' => 'Apply Position : Fresher Developer',
                    'text' => '
        <p>
        * Work in the project  :</br>
        + Build interface</br>
        + Build functionality</br>
        + Optimize code</br>
        * Technology used</br>
        + Use Git, Docker, My Sql, Visual Studio Code</br>
        + Framework Laravel, Ajax, Bootstrap, slick, Jquery, Html, CSS, Js.</br>
     </p>
        ',
                    'start_at' => '2021/07/07',
                    'finish_at' => '2021/08/15',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 6,
                    'language_id' => 2,
                    'title' => 'Company introduction website(A.N.S ASIA)',
                    'position' => 'Apply Position : Fresher Developer',
                    'text' => '
        <p>
        * Work in the project  :</br>
        + Build interface</br>
        + Build functionality</br>
        + Optimize code</br>
        * Technology used</br>
        + Use Git, Docker, My Sql, Visual Studio Code</br>
        + Framework Laravel, Ajax, Bootstrap, slick, Jquery, Html, CSS, Js.</br>
     </p>
        ',
                    'start_at' => '2021/06/01',
                    'finish_at' => '2021/07/06',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 7,
                    'language_id' => 2,
                    'title' => 'Project Internship',
                    'position' => 'Apply Position : Intern Developer',
                    'text' => '
        <p>
        * Work in the project  :</br>
        + Build interface</br>
        + Build functionality</br>
        * Technology used</br>
        + Use Git, Docker, My Sql, Visual Studio Code</br>
        + Framework Laravel, Ajax, Bootstrap, Jquery, Html, CSS, Js.</br>
     </p>
        ',
                    'start_at' => '2021/04/01',
                    'finish_at' => '2021/05/28',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 8,
                    'language_id' => 2,
                    'title' => 'NODEJS SALES WEBSITE',
                    'position' => '<span class="pc">
        (Personal project: </br>
        Link github: <a href="https://github.com/s2attack2s/sonnt_webbanhang">https://github.com/s2attack2s/sonnt_webbanhang</a>
        </br>
        Link demo: <a href="https://web-sonnt.herokuapp.com/">https://web-sonnt.herokuapp.com/</a>
        )</span>
     <span class="mobile">
        (Personal project: </br>
        Link github: <a href="https://github.com/s2attack2s/sonnt_webbanhang">https://bitly.com.vn/fwcjey</a>
        </br>
        Link demo: <a href="https://web-sonnt.herokuapp.com/">https://bitly.com.vn/rbkt6j</a>
        )</span>',
                    'text' => '
        <p>
        * Working on the project: </br>
        + Data analysis </br>
        + UI / UX design </br>
        + Construction function </br>
        * Technology used </br>
        + Use Git, MongoDB, Visual Studio Code</br>
        + Framework Express, Bootstrap, Html, CSS, Js.</br>
     </p>
        ',
                    'start_at' => '2020/10/01',
                    'finish_at' => '2020/11/15',
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ]
        );
        DB::table('skill')->insert([[
            'id' => 1,
            'language_id' => 1,
            'text' => '
    <p>- Nắm bắt các kỹ năng cơ bản của Html, CSS, Javascript, PHP(Laravel), Ajax, Jquery.</br>
            - Biết sử dụng Git, Bootstrap, Slick.</br>
            - Hiểu biết cơ bản về Sql, MySql và MongoDB</br>
            - Sử dụng thành thạo các công cụ như Visual Studio Code, Eclipse, Netbean...</br>
         </p>',
            'created_at' => date('Y-m-d H:i:s')
        ], [
            'id' => 2,
            'language_id' => 2,
            'text' => '
<p> - Master the basic skills of Html, CSS, Javascript, PHP (Laravel), Ajax, Jquery. </br>
- Know how to use Git, Bootstrap, Slick. </br>
- Basic understanding of Sql, MySql and MongoDB </br>
- Proficient in using tools such as Visual Studio Code, Eclipse, Netbean ... </br>
</p> ',
            'created_at' => date('Y-m-d H:i:s')
        ]]);
        DB::table('certification')->insert(
            [
                [
                    'id' => 1,
                    'language_id' => 1,
                    'text' => '
            <p>Chứng chỉ Tin học văn phòng
            </p>',
                    'start_at' => '2019/05/26',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'language_id' => 1,
                    'text' => '
            <p>Chứng chỉ tiếng anh TopNotch 2.0
            </p>',
                    'start_at' => '2019/08/15',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 3,
                    'language_id' => 2,
                    'text' => '
            <p>Certificate in Office Informatics
            </p>',
                    'start_at' => '2019/05/26',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 4,
                    'language_id' => 2,
                    'text' => '
            <p>English Certificate TopNotch 2.0
            </p>',
                    'start_at' => '2019/08/15',
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ]
        );
        DB::table('awards')->insert(
            [
                [
                    'id' => 1,
                    'language_id' => 1,
                    'text' => '
        <p>Sinh viên giởi ngành CNTT khóa 14.3 - Kỳ Fall 2018
        </p>',
                    'start_at' => '2019/01/22',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'language_id' => 1,
                    'text' => '
        <p>Sinh viên giỏi ngành CNTT khoá 14.3 - Kỳ Summer 2020
        </p>',
                    'start_at' => '2020/10/06',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 3,
                    'language_id' => 2,
                    'text' => '
        <p>Outstanding Student of IT Course 14.3 - Fall Semester 2018
        </p>',
                    'start_at' => '2019/01/22',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 4,
                    'language_id' => 2,
                    'text' => '
        <p>Outstanding Student of IT Course 14.3 - Summer Semester 2020
        </p>',
                    'start_at' => '2020/10/06',
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ]
        );
        DB::table('languages')->insert(
            [
                [
                    'id' => 1,
                    'code' => 'vi',
                    'name' => 'Vietnamese',
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'code' => 'en',
                    'name' => 'English',
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ]
        );
    }
}
