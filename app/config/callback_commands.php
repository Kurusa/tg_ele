<?php

use App\Commands\Start;
use App\Commands\MainMenu\{Ads,
    Cancel,
    Menu\Description,
    Menu\Types,
    Order\Confirm,
    Payment,
    Socials,
    WantCake\WhatNeeded};
use App\Commands\MainMenu\CompanyInfo\{AboutUs, Buttons, Contact, OurValues};
use App\Commands\MainMenu\Feedback\{HaveProposal, LeaveReview};

return [
    'back' => Start::class,
    'main_menu' => Start::class,

    'info_about_company_b' => Buttons::class,
        'about_us_b' => AboutUs::class,
        'contact_b' => Contact::class,
        'our_values_b' => OurValues::class,

    'feedback_b' => \App\Commands\MainMenu\Feedback\Buttons::class,
        'leave_review_b' => LeaveReview::class,
        'have_proposal_b' => HaveProposal::class,

    'ads_b' => Ads::class,
    'socials_b' => Socials::class,
    'payment_b' => Payment::class,

    'want_my_cake_b' => WhatNeeded::class,
    'menu_b' => Types::class,
    'menuType' => Description::class,
    'cancelCake' => Cancel::class,

    'confirmOrder' =>  Confirm::class,
    'confirmCake' =>  \App\Commands\MainMenu\WantCake\Confirm::class,
    'order_b' => \App\Commands\MainMenu\Order\WhatNeeded::class,

];