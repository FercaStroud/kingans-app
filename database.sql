create table if not exists answers
(
    id          int auto_increment
        primary key,
    question_id int                                 null,
    title       varchar(120)                        null,
    created_at  timestamp default CURRENT_TIMESTAMP null,
    updated_at  date                                null,
    deleted_at  date                                null,
    created_by  int                                 null,
    updated_by  int                                 null
);

create table if not exists branches
(
    id         int auto_increment
        primary key,
    name       varchar(25)                         not null,
    city       varchar(25)                         not null,
    address    varchar(140)                        not null,
    phone      varchar(20)                         null,
    scheduling varchar(200)                        null,
    facebook   varchar(120)                        null,
    instagram  varchar(120)                        null,
    map        varchar(300)                        null,
    svg        varchar(60)                         null,
    created_by int                                 null,
    updated_by int                                 null,
    created_at timestamp default CURRENT_TIMESTAMP not null,
    updated_at datetime                            null,
    deleted_at datetime                            null
);

create table if not exists coupons
(
    id              int auto_increment
        primary key,
    name            varchar(140)                        not null,
    description     text                                null,
    code            varchar(20)                         not null,
    required_number int       default 0                 null,
    start           date                                null,
    end             date                                null,
    created_by      int                                 null,
    branch_id       int       default 0                 null,
    created_at      timestamp default CURRENT_TIMESTAMP null,
    updated_at      date                                null,
    deleted_at      date                                null,
    updated_by      int                                 null,
    src             varchar(255)                        null
);

create table if not exists news
(
    id         int auto_increment
        primary key,
    branch_id  int                                 not null,
    src        varchar(255)                        null,
    title      varchar(140)                        null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    updated_at date                                null,
    deleted_at date                                null,
    created_by int                                 null
);

create table if not exists panel_users
(
    id         int auto_increment
        primary key,
    branch_id  int                                 not null,
    username   varchar(20)                         null,
    type       char                                null comment 'A = Admin, G = Gerente, S = Supervisor',
    name       varchar(70)                         null,
    password   varchar(250)                        not null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    updated_at datetime                            null,
    deleted_at datetime                            null,
    created_by int                                 null comment 'creted by user id',
    updated_by int                                 null comment 'updated by user id',
    deleted_by int                                 null comment 'deleted by user id',
    constraint admin_users_username_uindex
        unique (username)
);

create table if not exists question_answer
(
    id                    int auto_increment
        primary key,
    answer_id             int                                 null,
    question_id           int                                 null,
    survey_id             int                                 null,
    other                 varchar(240)                        null,
    created_at            timestamp default CURRENT_TIMESTAMP null,
    updated_at            date                                null,
    deleted_at            date                                null,
    panel_user_created_by int                                 null,
    user_created_by       int                                 null
);

create table if not exists questions
(
    id         int auto_increment
        primary key,
    survey_id  int                                 null,
    type       varchar(20)                         null,
    title      varchar(120)                        null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    updated_at date                                null,
    deleted_at date                                null,
    created_by int                                 null,
    updated_by int                                 null
);

create table if not exists surveys
(
    id          int auto_increment
        primary key,
    name        varchar(30)                          not null,
    description text                                 null,
    created_at  timestamp  default CURRENT_TIMESTAMP null,
    updated_at  date                                 null,
    deleted_at  date                                 null,
    created_by  int                                  null,
    updated_by  int                                  null,
    is_active   tinyint(1) default 0                 null
);

create table if not exists user_coupons
(
    id         int auto_increment
        primary key,
    user_id    int                                 not null,
    coupon_id  int                                 not null,
    created_by int                                 null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    updated_at date                                null,
    deleted_at date                                null
);

create table if not exists users
(
    id         int auto_increment
        primary key,
    name       varchar(70)                         not null,
    phone      varchar(20)                         not null comment 'field for sign in',
    email      varchar(40)                         null,
    city       varchar(20)                         not null,
    gender     char                                null comment 'M & F',
    birthday   datetime                            not null,
    password   varchar(300)                        not null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    updated_at datetime                            null,
    deleted_at datetime                            null,
    created_by int                                 null comment 'created by user id',
    updated_by int                                 null comment 'updated by user id',
    deleted_by int                                 null comment 'deleted by user id',
    constraint users_email_uindex
        unique (email),
    constraint users_phone_uindex
        unique (phone)
);

create table if not exists visits
(
    id         int auto_increment
        primary key,
    user_id    int                                  not null,
    created_by int                                  not null,
    created_at timestamp  default CURRENT_TIMESTAMP null,
    updated_at date                                 null,
    deleted_at date                                 null,
    checked    tinyint(1) default 0                 not null
)
    comment 'Fetch notification (once at day)';


