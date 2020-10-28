INSERT INTO `hdlt-app`.`customers`
    SELECT
        `uid` as `id`,
        `cust_id`,
        `description`,
        `salesagent` as `sales_agent_id`,
        `payterms` as `payterms_id`,
        `date_created` as `created_at`,
        `date_updated` as `updated_at`
    FROM `herbsttool`.`customers`;

INSERT INTO `hdlt-app`.`billing_addresses`
    SELECT
        `uid` as `id`,
        `customer_id`,
        `name`,
        `street`,
        `zip`,
        `city`,
        `date_created` as `created_at`,
        `date_updated` as `updated_at`
    FROM `herbsttool`.`billing_addresses`;

INSERT INTO `hdlt-app`.`shipping_addresses`
    SELECT
        `uid` as `id`,
        `customer_id`,
        `name`,
        `street`,
        `zip`,
        `city`,
        `has_contract`,
        `date_created` as `created_at`,
        `date_updated` as `updated_at`
    FROM `herbsttool`.`shipping_addresses`;

INSERT INTO `hdlt-app`.`adsorbers`
	SELECT
		`uid`as `id`,
        `shipping_address_id`,
        `brand_id`,
        `model`,
        `volume`,
        `serial`,
        `pressure`,
        `year`,
        `active` as `is_active`,
        CONCAT(`next_service`, '-01') as next_service,
        `memo`,
        `date_created` as `created_at`,
        `date_updated` as `updated_at`
	FROM `herbsttool`.`components`
    WHERE `type`='adsorber';

INSERT INTO `hdlt-app`.`ad_dryers`
	SELECT
		`uid`as `id`,
		`shipping_address_id`,
		`brand_id`,
		`model`,
		`volume`,
		`serial`,
		`pressure`,
		`year`,
		`active` as `is_active`,
        CONCAT(`next_service`, '-01') as next_service,
        `memo`,
		`date_created` as `created_at`,
		`date_updated` as `updated_at`
	FROM `herbsttool`.`components`
	WHERE `type`='ad_dryer';

INSERT INTO `hdlt-app`.`compressors`
	SELECT
		`uid`as `id`,
		`shipping_address_id`,
		`brand_id`,
		`model`,
		`serial`,
		`pressure`,
		`power`,
		`year`,
		null as `type`,
		0 as `is_oilfree`,
		`active` as `is_active`,
        CONCAT(`next_service`, '-01') as next_service,
		`memo`,
		`date_created` as `created_at`,
		`date_updated` as `updated_at`
	FROM `herbsttool`.`components`
	WHERE `type`='compressor';

INSERT INTO `hdlt-app`.`controllers`
	SELECT
		`uid`as `id`,
		`shipping_address_id`,
		`brand_id`,
		`model`,
		`serial`,
		`year`,
		`active` as `is_active`,
		`memo`,
		`date_created` as `created_at`,
		`date_updated` as `updated_at`
	FROM `herbsttool`.`components`
	WHERE `type`='controller';

INSERT INTO `hdlt-app`.`filters`
	SELECT
		`uid`as `id`,
		`shipping_address_id`,
		`brand_id`,
		`model`,
        `element`,
		`active` as `is_active`,
        CONCAT(`next_service`, '-01') as next_service,
		`memo`,
		`date_created` as `created_at`,
		`date_updated` as `updated_at`
	FROM `herbsttool`.`components`
	WHERE `type`='filter';

INSERT INTO `hdlt-app`.`receivers`
	SELECT
		`uid` as `id`,
		`shipping_address_id`,
		`brand_id`,
		`volume`,
		`serial`,
		`pressure`,
		`year`,
        null as `type`,
		`active` as `is_active`,
        CONCAT(`next_service`, '-01') as next_service,
        `memo`,
		`date_created` as `created_at`,
		`date_updated` as `updated_at`
	FROM `herbsttool`.`components`
	WHERE `type`='receiver';

INSERT INTO `hdlt-app`.`ref_dryers`
	SELECT
		`uid` as `id`,
		`shipping_address_id`,
		`brand_id`,
        `model`,
		`serial`,
		`year`,
        `ref_type`,
        `ref_amount`,
		`active` as `is_active`,
        CONCAT(`next_service`, '-01') as next_service,
        `memo`,
		`date_created` as `created_at`,
		`date_updated` as `updated_at`
	FROM `herbsttool`.`components`
	WHERE `type`='ref_dryer';

INSERT INTO `hdlt-app`.`separators`
	SELECT
		`uid` as `id`,
		`shipping_address_id`,
		`brand_id`,
        `model`,
		`active` as `is_active`,
        CONCAT(`next_service`, '-01') as next_service,
        `memo`,
		`date_created` as `created_at`,
		`date_updated` as `updated_at`
	FROM `herbsttool`.`components`
	WHERE `type`='separator';

INSERT INTO `hdlt-app`.`sensors`
	SELECT
		`uid`as `id`,
		`shipping_address_id`,
		`brand_id`,
		`model`,
		`serial`,
		`year`,
		`active` as `is_active`,
		`memo`,
		`date_created` as `created_at`,
		`date_updated` as `updated_at`
	FROM `herbsttool`.`components`
	WHERE `type`='sensor';
