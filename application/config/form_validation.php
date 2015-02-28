<?php

//kasutajate info
$config['username_min_length'] = 4;
$config['username_max_length'] = 25;

$config['password_min_length'] = 4;
$config['password_max_length'] = 50;

$config['email_min_length'] = 3;
$config['email_max_length'] = 320;

//foorumid
$config['forumname_min_length'] = 3;
$config['forumname_max_length'] = 40;

//teemad
$config['topicname_min_length'] = 3;
$config['topicname_max_length'] = 100;

//postitused
$config['postcontent_min_length'] = 1;
$config['postcontent_max_length'] = 5000;

$config = array(
    'register' => array(
                    array(
                     'field'   => 'user',
                     'label'   => 'Kasutajanimi',
                     'rules'   => 'required|'.
                        'min_length['.$config['username_min_length'].']|'.
                        'max_length['.$config['username_max_length'].']|'.
                        'is_unique[users.name]|'.
                        'alpha_numeric'
                    ),
                    array(
                     'field'   => 'email',
                     'label'   => 'Email',
                     'rules'   => 'required|valid_email'
                    ),
                    array(
                     'field'   => 'pass',
                     'label'   => 'Salasõna',
                     'rules'   => 'required|'.
                        'min_length['.$config['password_min_length'].']|'.
                        'max_length['.$config['password_max_length'].']'
                    ),
                    array(
                     'field'   => 'passconf',
                     'label'   => 'Korda salasõna',
                     'rules'   => 'required|matches[pass]'
                    )
                  ),
    'login' => array(
                    array(
                     'field'   => 'user',
                     'label'   => 'Kasutajanimi',
                     'rules'   => 'required|'.
                        'min_length['.$config['username_min_length'].']|'.
                        'max_length['.$config['username_max_length'].']|'.
                        'alpha_numeric'
                    ),
                    array(
                     'field'   => 'pass',
                     'label'   => 'Salasõna',
                     'rules'   => 'required|'.
                        'min_length['.$config['password_min_length'].']|'.
                        'max_length['.$config['password_max_length'].']'
                    ),
                    array(
                     'field'   => 'loginAttempt_field',
                     'label'   => '',
                     'rules'   => 'callback_loginAttempt'
                    )
                ),
    'addforum' => array(
                    array(
                     'field'   => 'name',
                     'label'   => 'Nimi',
                     'rules'   => 'required|'.
                        'min_length['.$config['forumname_min_length'].']|'.
                        'max_length['.$config['forumname_max_length'].']|'.
                        'alpha_numeric'
                    ),
                    array(
                     'field'   => 'p_fid',
                     'label'   => 'Vanem',
                     'rules'   => 'required|is_natural'
                    )
                   ),
    'delforum' => array(
                    array(
                     'field'   => 'fid',
                     'label'   => 'Foorum',
                     'rules'   => 'required|is_natural_no_zero'
                    )
                  ),
    'addtopic' => array(
                    array(
                     'field'   => 'title',
                     'label'   => 'Pealkiri',
                     'rules'   => 'required|'.
                        'min_length['.$config['topicname_min_length'].']|'.
                        'max_length['.$config['topicname_max_length'].']|'.
                        'alpha_numeric|callback_addTopicCheck'
                    ),
                    array(
                     'field'   => 'content',
                     'label'   => 'Sisu',
                     'rules'   => 'required|'.
                        'min_length['.$config['postcontent_min_length'].']|'.
                        'max_length['.$config['postcontent_max_length'].']'
                    )
                  ),
    'addeditpost' => array(
                    array(
                     'field'   => 'content',
                     'label'   => 'Sisu',
                     'rules'   => 'required|'.
                        'min_length['.$config['postcontent_min_length'].']|'.
                        'max_length['.$config['postcontent_max_length'].']'
                    )
                  ),
    'changepassword' => array(
                            array(
                             'field'   => 'oldpass',
                             'label'   => 'Vana salasõna',
                             'rules'   => 'required|'.
                                'min_length['.$config['password_min_length'].']|'.
                                'max_length['.$config['password_max_length'].']|'.
                                'callback_changePasswordCheck'
                            ),
                            array(
                             'field'   => 'pass',
                             'label'   => 'Uus salasõna',
                             'rules'   => 'required|'.
                                'min_length['.$config['password_min_length'].']|'.
                                'max_length['.$config['password_max_length'].']|'.
                                'callback_oldNewPasswordMismatch'
                            ),
                            array(
                             'field'   => 'passconf',
                             'label'   => 'Uue salasõna kontroll',
                             'rules'   => 'required|matches[pass]'
                            )
                        ),
    'changepassword_no_old' => array(
                            array(
                             'field'   => 'pass',
                             'label'   => 'Uus salasõna',
                             'rules'   => 'required|'.
                                'min_length['.$config['password_min_length'].']|'.
                                'max_length['.$config['password_max_length'].']'
                            ),
                            array(
                             'field'   => 'passconf',
                             'label'   => 'Uue salasõna kontroll',
                             'rules'   => 'required|matches[pass]'
                            )
                        ),
    'registergoogle' => array(
                        array(
                         'field'   => 'user',
                         'label'   => 'Kasutajanimi',
                         'rules'   => 'required|'.
                                    'min_length['.$config['username_min_length'].']|'.
                                    'max_length['.$config['username_max_length'].']|'.
                                    'is_unique[users.name]|'.
                                    'alpha_numeric'
                        )
                     )
);

