<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private $articles = [
        'understanding-sexual-harassment' => [
            'title' => 'Understanding Sexual Harassment',
            'content' => [
                'Sexual harassment is any unwelcome sexual advance, request for sexual favors, or other verbal or physical conduct of a sexual nature that affects an individual\'s employment, education, or work environment.',
                'It can have serious psychological and emotional impacts on victims, including stress, anxiety, and decreased productivity.',
                'Recognizing sexual harassment in various environments is crucial to fostering safe and respectful spaces for everyone.'
            ],
            'image' => 'carousel-1.jpg',
            'published_date' => 'April 27, 2024',
        ],
        'recognizing-signs' => [
            'title' => 'Recognizing Signs of Sexual Harassment',
            'content' => [
                'Sexual harassment can manifest in many forms, including inappropriate touching, suggestive comments, and unwelcome advances.',
                'Common signs include discomfort, avoidance of certain individuals or places, and changes in behavior or performance.',
                'Being aware of these signs helps in early identification and intervention.'
            ],
            'image' => 'carousel-2.jpg',
            'published_date' => 'April 20, 2024',
        ],
        'how-to-prevent' => [
            'title' => 'How to Prevent Sexual Harassment',
            'content' => [
                'Prevention starts with clear policies and training programs that educate employees and students about acceptable behavior and consequences.',
                'Creating a culture of respect and accountability encourages individuals to speak up and report incidents without fear of retaliation.',
                'Regularly reviewing and updating prevention strategies ensures they remain effective and relevant.'
            ],
            'image' => 'carousel-3.jpg',
            'published_date' => 'April 22, 2024',
        ],
        'support-resources' => [
            'title' => 'Support Resources for Victims',
            'content' => [
                'Victims of sexual harassment can access various support resources, including counseling services, legal aid, and support groups.',
                'It is important to provide confidential and accessible channels for victims to seek help.',
                'Community organizations and workplace programs often offer valuable assistance and advocacy.'
            ],
            'image' => 'carousel-3.jpg',
            'published_date' => 'April 24, 2024',
        ],
        'legal-rights' => [
            'title' => 'Legal Rights and Reporting Procedures',
            'content' => [
                'Understanding your legal rights is essential when dealing with sexual harassment.',
                'There are established procedures for reporting incidents to employers, educational institutions, or legal authorities.',
                'Knowing these steps empowers victims to take action and seek justice.'
            ],
            'image' => 'carousel-3.jpg',
            'published_date' => 'April 25, 2024',
        ],
        'workplace-culture' => [
            'title' => 'Building a Respectful Workplace Culture',
            'content' => [
                'Strategies to foster respect and inclusivity to prevent harassment in the workplace.'
            ],
            'image' => 'carousel-2.jpg',
            'published_date' => 'April 26, 2024',
        ],
        'reporting-channels' => [
            'title' => 'Effective Reporting Channels',
            'content' => [
                'How to use official channels to report incidents safely and confidentially.'
            ],
            'image' => 'carousel-3.jpg',
            'published_date' => 'April 27, 2024',
        ],
        'emotional-impact' => [
            'title' => 'The Emotional Impact of Harassment',
            'content' => [
                'Understanding the psychological effects and how to support victims.'
            ],
            'image' => 'carousel-1.jpg',
            'published_date' => 'April 28, 2024',
        ],
        'bystander-intervention' => [
            'title' => 'Bystander Intervention Techniques',
            'content' => [
                'How to safely intervene and prevent harassment in various situations.'
            ],
            'image' => 'carousel-2.jpg',
            'published_date' => 'April 29, 2024',
        ],
        'policy-development' => [
            'title' => 'Developing Effective Anti-Harassment Policies',
            'content' => [
                'Guidelines for creating and implementing workplace policies.'
            ],
            'image' => 'carousel-3.jpg',
            'published_date' => 'April 30, 2024',
        ],
    ];

    public function show($slug)
    {
        if (!array_key_exists($slug, $this->articles)) {
            abort(404);
        }

        $article = $this->articles[$slug];

        return view('article', ['article' => $article]);
    }
}
