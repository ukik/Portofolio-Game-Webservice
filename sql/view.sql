# Host: localhost  (Version 5.7.24)
# Date: 2019-08-28 20:50:30
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# View "channel_helper_library_mission"
#

DROP VIEW IF EXISTS `channel_helper_library_mission`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_helper_library_mission`
  AS
  SELECT
    `id`,
    `code_mission`,
    `code_entity`,
    `title`,
    `mode`,
    `difficulty`,
    (CASE WHEN (`type` = 'premium') THEN 'premium' ELSE NULL END) AS 'premium',
    (CASE WHEN (`type` = 'normal') THEN 'normal' ELSE NULL END) AS 'normal',
    `package`,
    `terrain`,
    `tile`,
    `cash`,
    `coin`,
    `score`,
    `status`,
    `created_at`,
    `updated_at`,
    `deleted_at`
  FROM
    `library_mission`
  GROUP BY
    `id`
  ORDER BY `title`;

#
# View "channel_helper_record_maintenance"
#

DROP VIEW IF EXISTS `channel_helper_record_maintenance`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_helper_record_maintenance`
  AS
  SELECT
    `id`,
    `code_maintenance`,
    `title`,
    `due`,
    `start`,
    `finish`,
    `description`,
    COALESCE((CASE WHEN (`condition` = 'abort') THEN 'abort' WHEN (`condition` = 'pass') THEN 'pass' WHEN (`condition` = 'done') THEN 'done' END)) AS 'condition',
    COALESCE(SUM((CASE WHEN (`initial` = 'count_achievement') THEN `value` END)), 0) AS 'count_achievement',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_cash_achievement') THEN `value` END)), 0) AS 'sum_cash_achievement',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_coin_achievement') THEN `value` END)), 0) AS 'sum_coin_achievement',
    COALESCE(SUM((CASE WHEN (`initial` = 'count_bonus') THEN `value` END)), 0) AS 'count_bonus',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_cash_bonus') THEN `value` END)), 0) AS 'sum_cash_bonus',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_coin_bonus') THEN `value` END)), 0) AS 'sum_coin_bonus',
    COALESCE(SUM((CASE WHEN (`initial` = 'count_freebies') THEN `value` END)), 0) AS 'count_freebies',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_cash_freebies') THEN `value` END)), 0) AS 'sum_cash_freebies',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_coin_freebies') THEN `value` END)), 0) AS 'sum_coin_freebies',
    COALESCE(SUM((CASE WHEN (`initial` = 'count_game') THEN `value` END)), 0) AS 'count_game',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_cash_game') THEN `value` END)), 0) AS 'sum_cash_game',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_coin_game') THEN `value` END)), 0) AS 'sum_coin_game',
    COALESCE(SUM((CASE WHEN (`initial` = 'count_mission') THEN `value` END)), 0) AS 'count_mission',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_cash_mission') THEN `value` END)), 0) AS 'sum_cash_mission',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_coin_mission') THEN `value` END)), 0) AS 'sum_coin_mission',
    COALESCE(SUM((CASE WHEN (`initial` = 'count_withdraw') THEN `value` END)), 0) AS 'count_withdraw',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_cash_fee_withdraw') THEN `value` END)), 0) AS 'sum_cash_fee_withdraw',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_coin_free_withdraw') THEN `value` END)), 0) AS 'sum_coin_free_withdraw',
    COALESCE(SUM((CASE WHEN (`initial` = 'count_tools') THEN `value` END)), 0) AS 'count_tools',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_cash_discount_tools') THEN `value` END)), 0) AS 'sum_cash_discount_tools',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_coin_discount_tools') THEN `value` END)), 0) AS 'sum_coin_discount_tools',
    COALESCE(SUM((CASE WHEN (`initial` = 'count_vehicle') THEN `value` END)), 0) AS 'count_vehicle',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_cash_discount_vehicle') THEN `value` END)), 0) AS 'sum_cash_discount_vehicle',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_coin_discount_vehicle') THEN `value` END)), 0) AS 'sum_coin_discount_vehicle',
    COALESCE(SUM((CASE WHEN (`initial` = 'count_purchase') THEN `value` END)), 0) AS 'count_purchase',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_cash_discount_purchase') THEN `value` END)), 0) AS 'sum_cash_discount_purchase',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_coin_discount_purchase') THEN `value` END)), 0) AS 'sum_coin_discount_purchase',
    COALESCE(SUM((CASE WHEN (`initial` = 'count_player') THEN `value` END)), 0) AS 'count_player',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_score_in_player') THEN `value` END)), 0) AS 'sum_score_in_player',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_cash_in_player') THEN `value` END)), 0) AS 'sum_cash_in_player',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_coin_in_player') THEN `value` END)), 0) AS 'sum_coin_in_player',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_cash_out_player') THEN `value` END)), 0) AS 'sum_cash_out_player',
    COALESCE(SUM((CASE WHEN (`initial` = 'sum_coin_out_player') THEN `value` END)), 0) AS 'sum_coin_out_player',
    `created_at`,
    `updated_at`,
    `deleted_at`
  FROM
    `mutation_record_maintenance`
  GROUP BY
    `title`, `due`, `day`;

#
# View "channel_income_record_achievement"
#

DROP VIEW IF EXISTS `channel_income_record_achievement`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_income_record_achievement`
  AS
  SELECT
    `code_user`,
    COUNT(`code_achievement`) AS 'activity',
    SUM(`cash`) AS 'cash_in',
    SUM(`coin`) AS 'coin_in',
    SUM(`score`) AS 'score_in',
    NULL AS 'deleted_at'
  FROM
    `mutation_record_achievement`
  WHERE
    (`status` = 'enable')
  GROUP BY
    `code_user`;

#
# View "channel_income_record_bonus"
#

DROP VIEW IF EXISTS `channel_income_record_bonus`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_income_record_bonus`
  AS
  SELECT
    `code_user`,
    COUNT(`code_bonus`) AS 'activity',
    SUM(`cash`) AS 'cash_in',
    SUM(`coin`) AS 'coin_in',
    SUM(`score`) AS 'score_in',
    NULL AS 'deleted_at'
  FROM
    `mutation_record_bonus`
  WHERE
    (`status` = 'enable')
  GROUP BY
    `code_user`;

#
# View "channel_income_record_freebies"
#

DROP VIEW IF EXISTS `channel_income_record_freebies`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_income_record_freebies`
  AS
  SELECT
    `code_user`,
    COUNT(`code_freebies`) AS 'activity',
    SUM(`cash`) AS 'cash_in',
    SUM(`coin`) AS 'coin_in',
    SUM(`score`) AS 'score_in',
    NULL AS 'deleted_at'
  FROM
    `mutation_record_freebies`
  WHERE
    (`status` = 'enable')
  GROUP BY
    `code_user`;

#
# View "channel_income_record_game"
#

DROP VIEW IF EXISTS `channel_income_record_game`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_income_record_game`
  AS
  SELECT
    `code_user`,
    COUNT(`code_game`) AS 'activity',
    SUM(`cash`) AS 'cash_in',
    SUM(`coin`) AS 'coin_in',
    SUM(`score`) AS 'score_in',
    NULL AS 'deleted_at'
  FROM
    `mutation_record_game`
  WHERE
    (`status` = 'enable')
  GROUP BY
    `code_user`;

#
# View "channel_income_record_mission"
#

DROP VIEW IF EXISTS `channel_income_record_mission`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_income_record_mission`
  AS
  SELECT
    `code_user`,
    COUNT(`code_mission`) AS 'activity',
    SUM(`cash`) AS 'cash_in',
    SUM(`coin`) AS 'coin_in',
    SUM(`score`) AS 'score_in',
    NULL AS 'deleted_at'
  FROM
    `mutation_record_mission`
  WHERE
    (`status` = 'enable')
  GROUP BY
    `code_user`;

#
# View "channel_income_record_purchase"
#

DROP VIEW IF EXISTS `channel_income_record_purchase`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_income_record_purchase`
  AS
  SELECT
    `code_user`,
    COUNT(`code_purchase`) AS 'activity',
    COALESCE(SUM((CASE WHEN (`currency` = 'cash') THEN (`price` - ((`price` * `discount`) / 100)) END)), 0) AS 'price_cash',
    COALESCE(SUM((CASE WHEN (`currency` = 'cash') THEN `value` END)), 0) AS 'cash_in',
    COALESCE(SUM((CASE WHEN (`currency` = 'coin') THEN (`price` - ((`price` * `discount`) / 100)) END)), 0) AS 'price_coin',
    COALESCE(SUM((CASE WHEN (`currency` = 'coin') THEN `value` END)), 0) AS 'coin_in',
    COALESCE(SUM((CASE WHEN (`currency` = 'score') THEN `value` END)), 0) AS 'score_in',
    NULL AS 'deleted_at'
  FROM
    `mutation_record_purchase`
  WHERE
    (`status` = 'enable')
  GROUP BY
    `code_user`;

#
# View "channel_outcome_record_tools"
#

DROP VIEW IF EXISTS `channel_outcome_record_tools`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_outcome_record_tools`
  AS
  SELECT
    `code_user`,
    COUNT(`code_tools`) AS 'activity',
    SUM((`cash` + ((`cash` * `discount`) / 100))) AS 'cash_out',
    SUM((`coin` + ((`coin` * `discount`) / 100))) AS 'coin_out',
    NULL AS 'deleted_at'
  FROM
    `mutation_record_tools`
  WHERE
    (`status` = 'enable')
  GROUP BY
    `code_user`;

#
# View "channel_outcome_record_vehicle"
#

DROP VIEW IF EXISTS `channel_outcome_record_vehicle`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_outcome_record_vehicle`
  AS
  SELECT
    `code_user`,
    COUNT(`code_vehicle`) AS 'activity',
    SUM((`cash` + ((`cash` * `discount`) / 100))) AS 'cash_out',
    SUM((`coin` + ((`coin` * `discount`) / 100))) AS 'coin_out',
    NULL AS 'deleted_at'
  FROM
    `mutation_record_vehicle`
  WHERE
    (`status` = 'enable')
  GROUP BY
    `code_user`;

#
# View "channel_outcome_record_withdraw"
#

DROP VIEW IF EXISTS `channel_outcome_record_withdraw`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_outcome_record_withdraw`
  AS
  SELECT
    `code_user`,
    COUNT(`code_withdraw`) AS 'activity',
    SUM((`cash` + ((`cash` * `fee`) / 100))) AS 'cash_out',
    SUM((`coin` + ((`coin` * `fee`) / 100))) AS 'coin_out',
    NULL AS 'deleted_at'
  FROM
    `mutation_record_withdraw`
  WHERE
    (`status` = 'enable')
  GROUP BY
    `code_user`;

#
# View "channel_reference_intro"
#

DROP VIEW IF EXISTS `channel_reference_intro`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_reference_intro`
  AS
  SELECT
    `mutation_reference_intro`.`id`,
    `user_profile`.`code_user`,
    `user_profile`.`code_profile`,
    `library_intro`.`code_intro`,
    `library_intro`.`title`,
    `library_intro`.`description`,
    `library_intro`.`variant`,
    `library_intro`.`status`,
    `mutation_reference_intro`.`created_at`,
    `mutation_reference_intro`.`updated_at`
  FROM
    ((`mutation_reference_intro`
      JOIN `library_intro` ON ((`library_intro`.`code_intro` = `mutation_reference_intro`.`code_intro`)))
      JOIN `user_profile` ON ((`mutation_reference_intro`.`code_user` = `user_profile`.`code_user`)))
  GROUP BY
    `user_profile`.`code_user`, `user_profile`.`code_profile`, `library_intro`.`code_intro`, `mutation_reference_intro`.`updated_at`
  ORDER BY `mutation_reference_intro`.`id` DESC;

#
# View "channel_summary_income"
#

DROP VIEW IF EXISTS `channel_summary_income`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_summary_income`
  AS
  SELECT
    `income_summary`.`code_user`,
    SUM(`income_summary`.`activity`) AS 'activity',
    SUM(`income_summary`.`cash_in`) AS 'cash_in',
    SUM(`income_summary`.`coin_in`) AS 'coin_in',
    SUM(`income_summary`.`score_in`) AS 'score_in',
    `income_summary`.`deleted_at`
  FROM
    (SELECT
      `channel_income_record_achievement`.`code_user`,
      `channel_income_record_achievement`.`activity`,
      `channel_income_record_achievement`.`cash_in`,
      `channel_income_record_achievement`.`coin_in`,
      `channel_income_record_achievement`.`score_in`,
      `channel_income_record_achievement`.`deleted_at`
    FROM
      `channel_income_record_achievement`
    UNION ALL
    SELECT
      `channel_income_record_bonus`.`code_user`,
      `channel_income_record_bonus`.`activity`,
      `channel_income_record_bonus`.`cash_in`,
      `channel_income_record_bonus`.`coin_in`,
      `channel_income_record_bonus`.`score_in`,
      `channel_income_record_bonus`.`deleted_at`
    FROM
      `channel_income_record_bonus`
    UNION ALL
    SELECT
      `channel_income_record_freebies`.`code_user`,
      `channel_income_record_freebies`.`activity`,
      `channel_income_record_freebies`.`cash_in`,
      `channel_income_record_freebies`.`coin_in`,
      `channel_income_record_freebies`.`score_in`,
      `channel_income_record_freebies`.`deleted_at`
    FROM
      `channel_income_record_freebies`
    UNION ALL
    SELECT
      `channel_income_record_game`.`code_user`,
      `channel_income_record_game`.`activity`,
      `channel_income_record_game`.`cash_in`,
      `channel_income_record_game`.`coin_in`,
      `channel_income_record_game`.`score_in`,
      `channel_income_record_game`.`deleted_at`
    FROM
      `channel_income_record_game`
    UNION ALL
    SELECT
      `channel_income_record_purchase`.`code_user`,
      `channel_income_record_purchase`.`activity`,
      `channel_income_record_purchase`.`cash_in`,
      `channel_income_record_purchase`.`coin_in`,
      `channel_income_record_purchase`.`score_in`,
      `channel_income_record_purchase`.`deleted_at`
    FROM
      `channel_income_record_purchase`
    UNION ALL
    SELECT
      `channel_income_record_mission`.`code_user`,
      `channel_income_record_mission`.`activity`,
      `channel_income_record_mission`.`cash_in`,
      `channel_income_record_mission`.`coin_in`,
      `channel_income_record_mission`.`score_in`,
      `channel_income_record_mission`.`deleted_at`
    FROM
      `channel_income_record_mission`) income_summary
  GROUP BY
    `income_summary`.`code_user`;

#
# View "channel_summary_outcome"
#

DROP VIEW IF EXISTS `channel_summary_outcome`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_summary_outcome`
  AS
  SELECT
    `outcome_summary`.`code_user`,
    SUM(`outcome_summary`.`activity`) AS 'activity',
    SUM(`outcome_summary`.`cash_out`) AS 'cash_out',
    SUM(`outcome_summary`.`coin_out`) AS 'coin_out',
    `outcome_summary`.`deleted_at`
  FROM
    (SELECT
      `channel_outcome_record_tools`.`code_user`,
      `channel_outcome_record_tools`.`activity`,
      `channel_outcome_record_tools`.`cash_out`,
      `channel_outcome_record_tools`.`coin_out`,
      `channel_outcome_record_tools`.`deleted_at`
    FROM
      `channel_outcome_record_tools`
    UNION ALL
    SELECT
      `channel_outcome_record_vehicle`.`code_user`,
      `channel_outcome_record_vehicle`.`activity`,
      `channel_outcome_record_vehicle`.`cash_out`,
      `channel_outcome_record_vehicle`.`coin_out`,
      `channel_outcome_record_vehicle`.`deleted_at`
    FROM
      `channel_outcome_record_vehicle`
    UNION ALL
    SELECT
      `channel_outcome_record_withdraw`.`code_user`,
      `channel_outcome_record_withdraw`.`activity`,
      `channel_outcome_record_withdraw`.`cash_out`,
      `channel_outcome_record_withdraw`.`coin_out`,
      `channel_outcome_record_withdraw`.`deleted_at`
    FROM
      `channel_outcome_record_withdraw`) outcome_summary
  GROUP BY
    `outcome_summary`.`code_user`;

#
# View "channel_summary_stats"
#

DROP VIEW IF EXISTS `channel_summary_stats`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `channel_summary_stats`
  AS
  SELECT
    `code_user`,
    COUNT(`code_game`) AS 'activity',
    COUNT(`premium`) AS 'premium',
    COUNT(`normal`) AS 'normal',
    SUM(`star`) AS 'star',
    SUM(`cash`) AS 'cash',
    SUM(`coin`) AS 'coin',
    SUM(`score`) AS 'score'
  FROM
    `mutation_record_game`
  WHERE
    (`status` = 'enable')
  GROUP BY
    `code_user`;
