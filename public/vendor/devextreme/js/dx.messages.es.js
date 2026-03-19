/*!
* DevExtreme - Spanish (es) localization messages
*/
(function(factory) {
    if (typeof define === "function" && define.amd) {
        define(function(require) {
            factory(require("devextreme/localization"));
        });
    } else if (typeof module === "object" && module.exports) {
        factory(require("devextreme/localization"));
    } else {
        factory(DevExpress.localization);
    }
})(function(localization) {
    localization.loadMessages({
        es: {
            Yes: "Sí",
            No: "No",
            Cancel: "Cancelar",
            Close: "Cerrar",
            Clear: "Limpiar",
            Done: "Hecho",
            Loading: "Cargando...",
            Select: "Seleccionar...",
            Search: "Buscar",
            Back: "Atrás",
            OK: "Aceptar",

            // DataGrid
            "dxDataGrid-editingEditRow": "Editar",
            "dxDataGrid-editingSaveRowChanges": "Guardar",
            "dxDataGrid-editingCancelRowChanges": "Cancelar",
            "dxDataGrid-editingDeleteRow": "Eliminar",
            "dxDataGrid-editingUndeleteRow": "Restaurar",
            "dxDataGrid-editingConfirmDeleteMessage": "¿Está seguro de que desea eliminar este registro?",
            "dxDataGrid-validationCancelChanges": "Cancelar cambios",
            "dxDataGrid-groupContinuesMessage": "Continúa en la siguiente página",
            "dxDataGrid-groupContinuedMessage": "Continuación de la página anterior",
            "dxDataGrid-groupHeaderText": "Agrupar por esta columna",
            "dxDataGrid-ungroupHeaderText": "Desagrupar",
            "dxDataGrid-ungroupAllText": "Desagrupar todo",
            "dxDataGrid-editingSaveAllChanges": "Guardar cambios",
            "dxDataGrid-editingCancelAllChanges": "Descartar cambios",
            "dxDataGrid-editingAddRow": "Agregar fila",
            "dxDataGrid-summaryMin": "Mín: {0}",
            "dxDataGrid-summaryMinOtherColumn": "Mín de {1} es {0}",
            "dxDataGrid-summaryMax": "Máx: {0}",
            "dxDataGrid-summaryMaxOtherColumn": "Máx de {1} es {0}",
            "dxDataGrid-summaryAvg": "Prom: {0}",
            "dxDataGrid-summaryAvgOtherColumn": "Prom de {1} es {0}",
            "dxDataGrid-summarySum": "Suma: {0}",
            "dxDataGrid-summarySumOtherColumn": "Suma de {1} es {0}",
            "dxDataGrid-summaryCount": "Cantidad: {0}",
            "dxDataGrid-columnChooserTitle": "Selector de columnas",
            "dxDataGrid-columnChooserEmptyText": "Arrastre una columna aquí para ocultarla",
            "dxDataGrid-selectedRow": "Fila seleccionada",
            "dxDataGrid-exportTo": "Exportar",
            "dxDataGrid-exportToExcel": "Exportar a Excel",
            "dxDataGrid-exporting": "Exportando...",
            "dxDataGrid-excelFormat": "Archivo Excel",
            "dxDataGrid-filterRow-betweenStartText": "Inicio",
            "dxDataGrid-filterRow-betweenEndText": "Fin",
            "dxDataGrid-filterRow-operationEquals": "Igual",
            "dxDataGrid-filterRow-operationNotEquals": "No igual",
            "dxDataGrid-filterRow-operationLess": "Menor que",
            "dxDataGrid-filterRow-operationLessOrEquals": "Menor o igual que",
            "dxDataGrid-filterRow-operationGreater": "Mayor que",
            "dxDataGrid-filterRow-operationGreaterOrEquals": "Mayor o igual que",
            "dxDataGrid-filterRow-operationStartsWith": "Comienza con",
            "dxDataGrid-filterRow-operationContains": "Contiene",
            "dxDataGrid-filterRow-operationNotContains": "No contiene",
            "dxDataGrid-filterRow-operationEndsWith": "Termina con",
            "dxDataGrid-filterRow-operationBetween": "Entre",
            "dxDataGrid-filterRow-resetOperationText": "Restablecer",
            "dxDataGrid-applyFilterText": "Aplicar filtro",
            "dxDataGrid-trueText": "Verdadero",
            "dxDataGrid-falseText": "Falso",
            "dxDataGrid-sortingAscendingText": "Ordenar ascendente",
            "dxDataGrid-sortingDescendingText": "Ordenar descendente",
            "dxDataGrid-sortingClearText": "Limpiar ordenamiento",
            "dxDataGrid-ariaDataGrid": "Tabla de datos",
            "dxDataGrid-ariaSearchInGrid": "Buscar en la tabla de datos",
            "dxDataGrid-ariaColumn": "Columna",
            "dxDataGrid-ariaValue": "Valor",
            "dxDataGrid-ariaFilterCell": "Filtrar celda",
            "dxDataGrid-ariaCollapse": "Contraer",
            "dxDataGrid-ariaExpand": "Expandir",
            "dxDataGrid-ariaSearchBox": "Buscar",
            "dxDataGrid-filterBuilderPopupTitle": "Constructor de filtros",
            "dxDataGrid-filterPanelCreateFilter": "Crear filtro",
            "dxDataGrid-filterPanelClearFilter": "Limpiar",
            "dxDataGrid-filterPanelFilterEnabledHint": "Habilitar filtro",
            "dxDataGrid-noDataText": "Sin datos",
            "dxDataGrid-searchPanelPlaceholder": "Buscar...",
            "dxDataGrid-headerFilterEmptyValue": "(Vacíos)",
            "dxDataGrid-headerFilterOK": "Aceptar",
            "dxDataGrid-headerFilterCancel": "Cancelar",

            // Pager
            "dxPager-infoText": "Página {0} de {1} ({2} elementos)",
            "dxPager-pagesCountText": "de",
            "dxPager-pageSizesAllText": "Todo",
            "dxPager-page": "Página {0}",
            "dxPager-prevPage": "Página anterior",
            "dxPager-nextPage": "Página siguiente",
            "dxPager-ariaLabel": "Navegación de páginas",
            "dxPager-ariaPageSize": "Tamaño de página",
            "dxPager-ariaPageNumber": "Número de página",

            // List
            "dxList-pullingDownText": "Tire hacia abajo para actualizar...",
            "dxList-pulledDownText": "Suelte para actualizar...",
            "dxList-refreshingText": "Actualizando...",
            "dxList-pageLoadingText": "Cargando...",
            "dxList-nextButtonText": "Más",
            "dxList-selectAll": "Seleccionar todo",

            // FilterBuilder
            "dxFilterBuilder-and": "Y",
            "dxFilterBuilder-or": "O",
            "dxFilterBuilder-notAnd": "No Y",
            "dxFilterBuilder-notOr": "No O",
            "dxFilterBuilder-addCondition": "Agregar condición",
            "dxFilterBuilder-addGroup": "Agregar grupo",
            "dxFilterBuilder-enterValueText": "<ingrese un valor>",
            "dxFilterBuilder-filterOperationEquals": "Igual",
            "dxFilterBuilder-filterOperationNotEquals": "No igual",
            "dxFilterBuilder-filterOperationLess": "Menor que",
            "dxFilterBuilder-filterOperationLessOrEquals": "Menor o igual que",
            "dxFilterBuilder-filterOperationGreater": "Mayor que",
            "dxFilterBuilder-filterOperationGreaterOrEquals": "Mayor o igual que",
            "dxFilterBuilder-filterOperationStartsWith": "Comienza con",
            "dxFilterBuilder-filterOperationContains": "Contiene",
            "dxFilterBuilder-filterOperationNotContains": "No contiene",
            "dxFilterBuilder-filterOperationEndsWith": "Termina con",
            "dxFilterBuilder-filterOperationIsBlank": "Está vacío",
            "dxFilterBuilder-filterOperationIsNotBlank": "No está vacío",
            "dxFilterBuilder-filterOperationBetween": "Entre",
            "dxFilterBuilder-filterOperationAnyOf": "Cualquiera de",
            "dxFilterBuilder-filterOperationNoneOf": "Ninguno de",

            // Scheduler
            "dxScheduler-editorLabelTitle": "Asunto",
            "dxScheduler-editorLabelStartDate": "Fecha de inicio",
            "dxScheduler-editorLabelEndDate": "Fecha de fin",
            "dxScheduler-editorLabelDescription": "Descripción",
            "dxScheduler-editorLabelRecurrence": "Repetir",
            "dxScheduler-openAppointment": "Abrir cita",
            "dxScheduler-recurrenceNever": "Nunca",
            "dxScheduler-recurrenceDaily": "Diario",
            "dxScheduler-recurrenceWeekly": "Semanal",
            "dxScheduler-recurrenceMonthly": "Mensual",
            "dxScheduler-recurrenceYearly": "Anual",
            "dxScheduler-switcherDay": "Día",
            "dxScheduler-switcherWeek": "Semana",
            "dxScheduler-switcherWorkWeek": "Semana laboral",
            "dxScheduler-switcherMonth": "Mes",
            "dxScheduler-switcherAgenda": "Agenda",
            "dxScheduler-switcherTimelineDay": "Línea de tiempo Día",
            "dxScheduler-switcherTimelineWeek": "Línea de tiempo Semana",
            "dxScheduler-switcherTimelineWorkWeek": "Línea de tiempo Semana laboral",
            "dxScheduler-switcherTimelineMonth": "Línea de tiempo Mes",
            "dxScheduler-allDay": "Todo el día",
            "dxScheduler-confirmRecurrenceEditMessage": "¿Desea editar solo esta cita o toda la serie?",
            "dxScheduler-confirmRecurrenceDeleteMessage": "¿Desea eliminar solo esta cita o toda la serie?",
            "dxScheduler-confirmRecurrenceEditSeries": "Editar serie",
            "dxScheduler-confirmRecurrenceDeleteSeries": "Eliminar serie",
            "dxScheduler-confirmRecurrenceEditOccurrence": "Editar cita",
            "dxScheduler-confirmRecurrenceDeleteOccurrence": "Eliminar cita",
            "dxScheduler-noTimezoneTitle": "Sin zona horaria",
            "dxScheduler-moreAppointments": "{0} más",

            // Calendar
            "dxCalendar-todayButtonText": "Hoy",
            "dxCalendar-ariaWidgetName": "Calendario",

            // Form
            "dxForm-requiredMessage": "{0} es obligatorio",
            "dxForm-optionalMark": "opcional",

            // Lookup
            "dxLookup-searchPlaceholder": "Cantidad mínima de caracteres: {0}",

            // File Uploader
            "dxFileUploader-selectFile": "Seleccionar archivo",
            "dxFileUploader-dropFile": "o arrastre el archivo aquí",
            "dxFileUploader-bytes": "bytes",
            "dxFileUploader-kb": "KB",
            "dxFileUploader-Mb": "MB",
            "dxFileUploader-Gb": "GB",
            "dxFileUploader-upload": "Subir",
            "dxFileUploader-uploaded": "Subido",
            "dxFileUploader-readyToUpload": "Listo para subir",
            "dxFileUploader-uploadFailedMessage": "Error al subir",
            "dxFileUploader-invalidFileExtension": "Tipo de archivo no permitido",
            "dxFileUploader-invalidMaxFileSize": "El archivo es demasiado grande",
            "dxFileUploader-invalidMinFileSize": "El archivo es demasiado pequeño",

            // Popup
            "dxPopup-done": "Hecho",
            "dxPopup-title": "Información",

            // ActionSheet
            "dxActionSheet-cancelBtnText": "Cancelar",

            // Common
            "dxCollectionWidget-noDataText": "Sin datos para mostrar",

            // Tabs
            "dxTabs-selectedTabText": "Pestaña seleccionada",

            // Validation
            "validation-required": "Obligatorio",
            "validation-required-formatted": "{0} es obligatorio",
            "validation-numeric": "El valor debe ser un número",
            "validation-numeric-formatted": "{0} debe ser un número",
            "validation-range": "El valor está fuera de rango",
            "validation-range-formatted": "{0} está fuera de rango",
            "validation-stringLength": "La longitud del valor no es correcta",
            "validation-stringLength-formatted": "La longitud de {0} no es correcta",
            "validation-custom": "El valor no es válido",
            "validation-custom-formatted": "{0} no es válido",
            "validation-async": "El valor no es válido",
            "validation-async-formatted": "{0} no es válido",
            "validation-compare": "Los valores no coinciden",
            "validation-compare-formatted": "{0} no coincide",
            "validation-pattern": "El valor no coincide con el patrón",
            "validation-pattern-formatted": "{0} no coincide con el patrón",
            "validation-email": "El correo electrónico no es válido",
            "validation-email-formatted": "{0} no es válido",
            "validation-mask": "El valor no es válido"
        }
    });
});
