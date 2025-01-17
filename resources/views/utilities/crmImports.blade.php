@include('components.head', ['pageName' => 'Importação Listas'])

<header class="header m-shadow">
</header>

<body id="content-area">

<div class="row center mb-3 d-flex align-items-center mx-2">
    <div class="col">
        @include('components.dropdownFilter', ['dropdownContent' => $campaigns, 'title' => 'Campanhas', 'id' => 'campaigns', 'isMultiple' => true])
    </div>
    <div class="col">
        @include('components.dropdownFilter', ['dropdownContent' => ['Site', 'Loja'], 'title' => 'Canal', 'id' => 'types', 'isMultiple' => true])
    </div>
    <div class="col">
        @include('components.dropdownFilter', ['dropdownContent' => ['Query', 'Csv'], 'title' => 'Metodo de Importação', 'id' => 'import', 'isMultiple' => false])
    </div>
</div>

<div class="row center mb-3 hidden" id="import-container">
<div class="col">
	<div class="card p-3 m-shadow">

		<div class="mb-4 hidden" id="form-query">
			<label class="form-label">Query</label>
			<textarea class="form-control" id="list-query" name="listQuery" rows="10"></textarea>
		</div>
    
		<div class="mb-3 w-50 hidden" id="form-file">
			<label for="formFileLg" class="form-label"></label>
			<input class="form-control form-control-lg" id="formFileLg" name="crmImportFile" type="file">
    </div>

    <div>

				<div class="col-auto d-flex justify-content-evenly">
					<button id="preview" 
									type="button" 
									class="btn btn-primary mb-3"
									hx-post="/dashboard/dispatchesImport/actions" 
									hx-target="#preview-results"
									hx-include="#list-query, #formFileLg"
									hx-vals='{"action": "preview"}'
									hx-encoding="multipart/form-data"
									>
							Preview da Base
					</button>

					<button id="send-data"
									type="button" 
									class="btn btn-primary mb-3"
									hx-post="/dashboard/dispatchesImport/actions" 
									hx-target="#preview-results"
									hx-include="#campaignsMenuButton, #typesMenuButton, #importMenuButton, #list-query, #formFileLg"
									hx-vals='{"action": "submit"}'
									hx-encoding="multipart/form-data"
									onclick="handleSubmit(event)">
						Enviar Lista
					</button>
        </div>

    </div>

		</div>
	</div>
</div>

<div class="row center mb-5">
    <div class="col">
        <div class="card p-3 m-shadow">
            <div id="preview-results">
							@if (!empty($listPreview))
									@include('components.dinamicTable', [
											'title' => 'Lista Exemplo',
											'tableData' => $listPreview['data'],
											'headerData' => $listPreview['columns'],
											'pageSize' => '20',
									])
							@else
									<p>No preview available</p>
							@endif
            </div>
        </div>
    </div>
</div>

</body>

<script>
	callTableData()
</script>

</html>