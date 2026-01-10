<?php

namespace Database\Seeders;

use App\Models\PageConfiguration;
use Illuminate\Database\Seeder;

class PageConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Welcome Page Configurations
        PageConfiguration::updateOrCreate(
            ['page_name' => 'welcome', 'section_key' => 'hero'],
            [
                'content' => [
                    'title' => 'Welcome to EduCore',
                    'subtitle' => 'Transform Your Educational Institution',
                    'description' => 'The complete educational management system for modern learning institutions. Streamline operations, enhance communication, and empower your educational ecosystem.',
                    'cta_primary' => 'Get Started',
                    'cta_secondary' => 'Learn More',
                    'background_image' => '/images/hero-bg.jpg',
                ],
                'order' => 1,
                'is_active' => true,
            ]
        );

        PageConfiguration::updateOrCreate(
            ['page_name' => 'welcome', 'section_key' => 'features'],
            [
                'content' => [
                    'title' => 'Why Choose EduCore?',
                    'subtitle' => 'Comprehensive Features for Modern Education',
                    'features' => [
                        [
                            'icon' => 'dashboard',
                            'title' => 'Unified Dashboard',
                            'description' => 'Centralized control panel for all educational operations',
                        ],
                        [
                            'icon' => 'attendance',
                            'title' => 'Smart Attendance',
                            'description' => 'Automated attendance tracking with real-time notifications',
                        ],
                        [
                            'icon' => 'analytics',
                            'title' => 'AI-Powered Analytics',
                            'description' => 'Data-driven insights for better decision making',
                        ],
                        [
                            'icon' => 'security',
                            'title' => 'Cloud Security',
                            'description' => 'Enterprise-grade security for your data',
                        ],
                        [
                            'icon' => 'parent',
                            'title' => 'Parent Portal',
                            'description' => 'Keep parents engaged and informed',
                        ],
                        [
                            'icon' => 'support',
                            'title' => '24/7 Support',
                            'description' => 'Round-the-clock technical assistance',
                        ],
                    ],
                ],
                'order' => 2,
                'is_active' => true,
            ]
        );

        PageConfiguration::updateOrCreate(
            ['page_name' => 'welcome', 'section_key' => 'stats'],
            [
                'content' => [
                    'title' => 'Trusted by Institutions Worldwide',
                    'stats' => [
                        ['value' => '500+', 'label' => 'Institutions'],
                        ['value' => '100K+', 'label' => 'Students'],
                        ['value' => '10K+', 'label' => 'Teachers'],
                        ['value' => '99.9%', 'label' => 'Uptime'],
                    ],
                ],
                'order' => 3,
                'is_active' => true,
            ]
        );

        // Dashboard Page Configurations
        PageConfiguration::updateOrCreate(
            ['page_name' => 'dashboard', 'section_key' => 'hero'],
            [
                'content' => [
                    'title' => 'Welcome Back!',
                    'subtitle' => 'Your Learning Journey Continues',
                    'show_carousel' => true,
                    'carousel_images' => [
                        '/images/carousel-1.jpg',
                        '/images/carousel-2.jpg',
                        '/images/carousel-3.jpg',
                    ],
                ],
                'order' => 1,
                'is_active' => true,
            ]
        );

        PageConfiguration::updateOrCreate(
            ['page_name' => 'dashboard', 'section_key' => 'platforms'],
            [
                'content' => [
                    'title' => 'Platforms',
                    'heading' => 'We Serve In Extensive Traits',
                    'description' => 'Educore is a holistic system empowering the entire education ecosystem through innovative digital transformation. It enhances learning, management, and collaboration for schools and universities worldwide.',
                    'cta_primary' => 'Get A Quote',
                    'cta_secondary' => 'Learn More',
                    'platforms' => [
                        [
                            'name' => 'School Management',
                            'image' => '/images/platform-school.jpg',
                            'description' => 'Complete K-12 school management solution',
                        ],
                        [
                            'name' => 'University System',
                            'image' => '/images/platform-university.jpg',
                            'description' => 'Advanced higher education management',
                        ],
                        [
                            'name' => 'Learning Center',
                            'image' => '/images/platform-learning.jpg',
                            'description' => 'Training and development platform',
                        ],
                    ],
                ],
                'order' => 2,
                'is_active' => true,
            ]
        );

        PageConfiguration::updateOrCreate(
            ['page_name' => 'dashboard', 'section_key' => 'about'],
            [
                'content' => [
                    'title' => 'About Educore System',
                    'description' => 'Educore is an innovative all-in-one educational management system built to streamline operations, enhance communication, and support smart learning environments for schools, colleges, and universities.',
                    'highlights' => [
                        'Unified Dashboard',
                        'Smart Attendance',
                        'AI-based Analytics',
                        'Cloud Security',
                        'Parent Portal',
                        '24/7 Support',
                    ],
                    'image' => '/images/about-educore.png',
                    'animation' => '/images/about-animation.gif',
                    'button_text' => 'EXPLORE MORE',
                ],
                'order' => 3,
                'is_active' => true,
            ]
        );

        PageConfiguration::updateOrCreate(
            ['page_name' => 'dashboard', 'section_key' => 'features'],
            [
                'content' => [
                    'title' => 'Educore Core Features',
                    'description' => 'Our system covers all critical aspects of educational management — from admissions to performance tracking — designed with flexibility and scalability at its heart.',
                    'features' => [
                        'Automated Workflows',
                        'Digital Classrooms',
                        'Financial Management',
                        'Secure Data Storage',
                        'Custom Reporting',
                    ],
                    'image' => '/images/core-features.png',
                    'animation' => '/images/features-animation.gif',
                    'button_text' => 'EXPLORE MORE',
                ],
                'order' => 4,
                'is_active' => true,
            ]
        );

        PageConfiguration::updateOrCreate(
            ['page_name' => 'dashboard', 'section_key' => 'certifications'],
            [
                'content' => [
                    'title' => 'Certifications',
                    'heading' => 'Trusted Certifications & Partnerships',
                    'description' => 'Educore holds industry-recognized certifications and partnerships that demonstrate our commitment to quality, compliance, and excellence in educational technology.',
                    'certificates' => [
                        [
                            'title' => 'ISO 9001:2015',
                            'description' => 'Quality Management System Certification',
                            'image' => '/images/cert-iso-9001.png',
                            'tags' => ['ISO 9001:2015', 'Quality Assurance'],
                        ],
                        [
                            'title' => 'ISO 27001:2013',
                            'description' => 'Information Security Management',
                            'image' => '/images/cert-iso-27001.png',
                            'tags' => ['ISO 27001:2013', 'Security'],
                        ],
                        [
                            'title' => 'GDPR Compliant',
                            'description' => 'Data Protection and Privacy Compliance',
                            'image' => '/images/cert-gdpr.png',
                            'tags' => ['GDPR', 'Privacy'],
                        ],
                        [
                            'title' => 'SOC 2 Type II',
                            'description' => 'Service Organization Control Certification',
                            'image' => '/images/cert-soc2.png',
                            'tags' => ['SOC 2', 'Compliance'],
                        ],
                        [
                            'title' => 'Microsoft Partner',
                            'description' => 'Certified Microsoft Education Partner',
                            'image' => '/images/cert-microsoft.png',
                            'tags' => ['Microsoft', 'Partnership'],
                        ],
                    ],
                    'button_text' => 'View All CERTIFICATIONS',
                ],
                'order' => 5,
                'is_active' => true,
            ]
        );
    }
}
