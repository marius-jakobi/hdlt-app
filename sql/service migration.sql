/**
 * ABs extrahieren und erstellen
 * Vorgang: #1 "legacy", gehört zu Herbst Drucklufttechnik GmbH D32000
 */
INSERT INTO `hdlt-app`.`order_confirmations`
	SELECT
		null as id,
		doc_id as document_number,
        1 as sales_process_id, #ID of sales process with process number "legacy"
        null as po_number,
        date_created as created_at,
        date_created as updated_at        
    FROM herbsttool.service_reports
    GROUP BY doc_id;
		
/**
 * Service-Berichte migrieren
 */
INSERT INTO `hdlt-app`.`service_reports`
	SELECT
		sr.`uid` as `id`,
        oc.id as order_confirmation_id,
		sr.`shipping_address_id`,
        null as `intent`,
        `text`,
        `test_run`,
        null as `additional_work_required`,
		sr.date_created as created_at,
		sr.date_created as updated_at
	FROM `herbsttool`.`service_reports` sr
    JOIN `hdlt-app`.`order_confirmations` oc ON oc.document_number = sr.doc_id;
 
/**
 * Komponenten zuordnen
 */
INSERT INTO `hdlt-app`.`adsorbers_service_reports`
	SELECT
		rcs.component_id,
		rcs.service_id as service_report_id,
		ss.id as scope_id
	FROM herbsttool.relation_component_service rcs
	JOIN herbsttool.components as c ON c.uid = rcs.component_id
	JOIN `hdlt-app`.`service_scopes` ss ON ss.description = rcs.scope
	WHERE c.type='adsorber';
    
INSERT INTO `hdlt-app`.`ad_dryers_service_reports`
	SELECT
		rcs.component_id,
		rcs.service_id as service_report_id,
		ss.id as scope_id
	FROM herbsttool.relation_component_service rcs
	JOIN herbsttool.components as c ON c.uid = rcs.component_id
	JOIN `hdlt-app`.`service_scopes` ss ON ss.description = rcs.scope
	WHERE c.type='ad_dryer';
    
INSERT INTO `hdlt-app`.`compressors_service_reports`
	SELECT
		rcs.component_id,
		rcs.service_id as service_report_id,
		ss.id as scope_id,
        rcs.hours_running,
        rcs.hours_loaded
	FROM herbsttool.relation_component_service rcs
	JOIN herbsttool.components as c ON c.uid = rcs.component_id
	JOIN `hdlt-app`.`service_scopes` ss ON ss.description = rcs.scope
	WHERE c.type='compressor';
    
INSERT INTO `hdlt-app`.`controllers_service_reports`
	SELECT
		rcs.component_id,
		rcs.service_id as service_report_id,
		ss.id as scope_id
	FROM herbsttool.relation_component_service rcs
	JOIN herbsttool.components as c ON c.uid = rcs.component_id
	JOIN `hdlt-app`.`service_scopes` ss ON ss.description = rcs.scope
	WHERE c.type='controller';
    
INSERT INTO `hdlt-app`.`filters_service_reports`
	SELECT
		rcs.component_id,
		rcs.service_id as service_report_id,
		ss.id as scope_id
	FROM herbsttool.relation_component_service rcs
	JOIN herbsttool.components as c ON c.uid = rcs.component_id
	JOIN `hdlt-app`.`service_scopes` ss ON ss.description = rcs.scope
	WHERE c.type='filter';
    
INSERT INTO `hdlt-app`.`receivers_service_reports`
	SELECT
		rcs.component_id,
		rcs.service_id as service_report_id,
		ss.id as scope_id
	FROM herbsttool.relation_component_service rcs
	JOIN herbsttool.components as c ON c.uid = rcs.component_id
	JOIN `hdlt-app`.`service_scopes` ss ON ss.description = rcs.scope
	WHERE c.type='receiver';
    
INSERT INTO `hdlt-app`.`ref_dryers_service_reports`
	SELECT
		rcs.component_id,
		rcs.service_id as service_report_id,
		ss.id as scope_id
	FROM herbsttool.relation_component_service rcs
	JOIN herbsttool.components as c ON c.uid = rcs.component_id
	JOIN `hdlt-app`.`service_scopes` ss ON ss.description = rcs.scope
	WHERE c.type='ref_dryer';
    
INSERT INTO `hdlt-app`.`sensors_service_reports`
	SELECT
		rcs.component_id,
		rcs.service_id as service_report_id,
		ss.id as scope_id
	FROM herbsttool.relation_component_service rcs
	JOIN herbsttool.components as c ON c.uid = rcs.component_id
	JOIN `hdlt-app`.`service_scopes` ss ON ss.description = rcs.scope
	WHERE c.type='sensor';
    
INSERT INTO `hdlt-app`.`separators_service_reports`
	SELECT
		rcs.component_id,
		rcs.service_id as service_report_id,
		ss.id as scope_id
	FROM herbsttool.relation_component_service rcs
	JOIN herbsttool.components as c ON c.uid = rcs.component_id
	JOIN `hdlt-app`.`service_scopes` ss ON ss.description = rcs.scope
	WHERE c.type='separator';
    
/**
 * Techniker verknüpfen
 */
INSERT INTO service_report_technicians
	SELECT
		rrt.report_id as service_report_id,
		rrt.technician_id,
		rrt.work_time,
		sr.date as work_date
	FROM herbsttool.relation_report_technician rrt
	JOIN herbsttool.service_reports sr ON sr.uid = rrt.report_id;

