<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $views = (int) Setting::valueFor('portfolio_views', 0) + 1;
        Setting::put('portfolio_views', $views);

        return view('portfolio', [
            'content' => $this->content(),
            'views' => $views,
        ]);
    }

    public function storeContact(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        ContactMessage::create([
            ...$data,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        return back()->with('contact_success', 'Message sent successfully. I will get back to you soon.');
    }

    public static function defaults(): array
    {
        return [
            'name' => 'Vishnupriyan R',
            'role' => 'Karur Frontend Developer | PHP Developer',
            'hero_title' => 'Building responsive web experiences with clean UI and practical backend logic.',
            'summary' => 'I am a Karur based developer with hands-on experience in HTML, CSS, JavaScript, PHP, CodeIgniter, MySQL, React, Tailwind CSS, and Figma. I enjoy turning business requirements into smooth, usable web applications.',
            'about_title' => 'Front-end developer grounded in HTML, CSS, JavaScript, and PHP.',
            'about_text' => "Passionate Front-end Developer with a strong foundation in HTML, CSS, JavaScript, and PHP. Skilled in UI/UX design, responsive web development, and dynamic web applications.\n\nBasic understanding of Java and SQL, enabling seamless collaboration with back-end developers. Excited to create visually appealing and high-performance web experiences in a fast-paced environment.",
            'about_facts' => "Education|B.E. Computer Science and Engineering (2020 - 2024), VSB Engineering College, Karur - Aggregate 79%\nExperience|9 months as Junior PHP Developer, plus a 3 month PHP development internship\nBased in|Karur, Tamil Nadu, India - open to relocating for the right opportunity\nLanguages|English and Tamil",
            'location' => 'Karur, Tamil Nadu, India',
            'email' => 'vishnupriyanrenganathan@gmail.com',
            'phone' => '+91 9629760070',
            'github' => 'https://github.com/vishnupriyan003',
            'linkedin' => 'https://www.linkedin.com/in/vishnupriyan-r-727538252',
            'relocation' => 'Open to relocating for the right opportunity',
            'stats' => "9 mo|Junior PHP role\n3 mo|CodeIgniter internship\n79%|B.E. CSE",
            'skills' => "Frontend|HTML5, CSS3, JavaScript ES6+, React, Bootstrap, Tailwind CSS, Flexbox, CSS Grid, responsive layout, and accessible UI basics.|fa-code\nBackend|PHP, CodeIgniter v3, CRUD modules, login systems, OTP verification, and server-side data flow.|fa-server\nDatabase|MySQL, SQL queries, DDL, DML, grouping, subqueries, functions, and practical database handling.|fa-database\nWorkflow|Git, GitHub, Figma, API integration, debugging, live website troubleshooting, WordPress familiarity, teamwork, and communication.|fa-tools",
            'experience' => "9 months|Junior PHP Developer|Knock The Globe Technologies|Built and maintained dynamic websites and web applications, supporting backend integration, MySQL data handling, debugging, performance improvements, and live website support.\n3 months (ended 20-05-2025)|PHP Developer Intern|Salesqueen Software Solutions|Developed CodeIgniter v3 modules including CRUD operations, user authentication, OTP generation, and vehicle management features connected with MySQL.",
            'project_title' => 'Vehicle Management Web Application',
            'project_description' => 'Developed a data-driven web application for managing customers, vehicles, and payments. The system supports adding, fetching, editing, payment calculations, and vehicle status tracking based on payment progress.',
            'project_tags' => 'HTML, CSS, JavaScript, PHP, MySQL',
            'project_points' => "Customer and vehicle records\nDynamic payment calculations\nStatus tracking logic\nFrontend and database integration",
            'additional_projects' => "Non-Helmet Detection System|Built a real-time helmet detection dashboard with alert-focused UI, interactive React visualizations, API calls, and responsive layouts using Flexbox and CSS Grid.|HTML, CSS, React, JavaScript, API Integration\nBus Route Scheduler|Created a user-friendly scheduling interface with dynamic user input handling, JavaScript form validation, Bootstrap layout work, and responsive CSS Grid structure.|HTML, CSS, JavaScript, Bootstrap",
            'education' => "2020 - 2024|B.E. Computer Science and Engineering|VSB Engineering College, Karur | Aggregate: 79%\n2019 - 2020|HSC|Cheran Matric Higher Secondary School, Karur\n2017 - 2018|SSLC|Cheran Matric Higher Secondary School, Karur",
            'seo_title' => 'Vishnupriyan R | Karur Frontend & PHP Developer',
            'seo_description' => 'Portfolio of Vishnupriyan R, a Karur based Frontend and PHP Developer skilled in HTML, CSS, JavaScript, React, PHP, CodeIgniter, MySQL, Tailwind CSS, UI/UX, Figma, and responsive web applications.',
            'seo_keywords' => 'Vishnupriyan R, Karur Frontend Developer, Karur PHP Developer, Web Developer Karur, React Developer Karur, CodeIgniter Developer, MySQL Developer, UI UX Developer, HTML CSS JavaScript, Tailwind CSS, Figma',
            'certificates' => "HTML|image/html.png\nCSS|image/css.jpg\nArduino|image/Arduino.jpeg\nSQL|image/sql.jpg",
            'certification_summary' => 'Frontend Development from Great Learning, SQL Fundamentals from JSPIDER, and ongoing MERN Stack learning with HTML, CSS, JavaScript, and MongoDB.',
            'soft_skills' => "Creativity\nTeamwork\nProblem-solving\nAttention to detail",
            'languages' => "English\nTamil",
            'resume_pdf' => 'vishnupriyan Resume-2.pdf',
            'resume_previews' => "image/respage1.jpg\nimage/respage2.jpg",
        ];
    }

    private function content(): array
    {
        $defaults = self::defaults();
        $content = [];

        foreach ($defaults as $key => $value) {
            $content[$key] = Setting::valueFor($key, $value);
        }

        $content['stats'] = $this->parseLines($content['stats'], ['value', 'label']);
        $content['about_facts'] = $this->parseLines($content['about_facts'], ['label', 'value']);
        $content['skills'] = $this->parseLines($content['skills'], ['title', 'text', 'icon']);
        $content['experience'] = $this->parseLines($content['experience'], ['meta', 'title', 'company', 'text']);
        $content['education'] = $this->parseLines($content['education'], ['year', 'title', 'text']);
        $content['project_tags'] = $this->parseCommaList($content['project_tags']);
        $content['project_points'] = $this->parseSimpleLines($content['project_points']);
        $content['additional_projects'] = $this->parseLines($content['additional_projects'], ['title', 'text', 'tags']);
        $content['certificates'] = $this->parseLines($content['certificates'], ['title', 'image']);
        $content['soft_skills'] = $this->parseSimpleLines($content['soft_skills']);
        $content['languages'] = $this->parseSimpleLines($content['languages']);
        $content['resume_previews'] = $this->parseSimpleLines($content['resume_previews']);

        return $content;
    }

    private function parseLines(string $value, array $keys): array
    {
        return collect(preg_split('/\r\n|\r|\n/', trim($value)))
            ->filter()
            ->map(function (string $line) use ($keys) {
                $parts = array_map('trim', explode('|', $line, count($keys)));
                return array_combine($keys, array_pad($parts, count($keys), ''));
            })
            ->values()
            ->all();
    }

    private function parseCommaList(string $value): array
    {
        return collect(explode(',', $value))->map(fn ($item) => trim($item))->filter()->values()->all();
    }

    private function parseSimpleLines(string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', trim($value)))->map(fn ($item) => trim($item))->filter()->values()->all();
    }
}
