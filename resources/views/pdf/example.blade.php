<style>
*, ::after, ::before {
	box-sizing: border-box;
	border: 0 solid #eee;
}
div{
	align-items: center;
	border-color: rgb(238, 238, 238);
	border-bottom-radius: 8px;
	border-style: solid;
	border-width: 0px;
	border-image-outset: 0;
	border-image-repeat: stretch;
	border-image-slice: 100%;
	border-image-source: none;
	border-image-width: 1;
	border-top-radius: 8px;
	box-sizing: border-box;
	display: grid;
	font-family: Roboto, sans-serif;
	font-feature-settings: normal;
	font-variation-settings: normal;
	justify-items: center;
	line-height: 22px;
	min-height: 140px;
	overflow: visible;
	padding: 24px;
	scrollbar-width: thin;
	tab-size: 4;
	width: 675px;
	box-shadow: 0 4px 6px -1px rgba(0,0,0,.1),0 2px 4px -2px rgba(0,0,0,.1);
}
table{
	text-align: left;
	table-layout: auto;
	min-width: max-content;
	width: 100%;
	text-indent: 0;
  	border-color: inherit;
  	border-collapse: collapse;
  	border-radius: .75rem;
  	box-shadow: 0 4px 6px -1px rgba(0,0,0,.1),0 2px 4px -2px rgba(0,0,0,.1);
}
table thead{
	box-shadow: 0 4px 6px -1px rgba(0,0,0,.1),0 2px 4px -2px rgba(0,0,0,.1);
}
table thead th{
	text-align: left;
	background-color: rgb(236 239 241/1);
	border-color: rgb(207 216 220/1);
	padding: 1rem;
	border-bottom-width: 1px;
}
table tbody{
	box-shadow: 0 4px 6px -1px rgba(0,0,0,.1),0 2px 4px -2px rgba(0,0,0,.1);
}
table tbody tr td{
	padding: 1rem;
	border-color: rgb(236 239 241/1);
	border-with: 0px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
}
.border-left{
	border-top-left-radius: 12px;
}
.border-right{
	border-top-right-radius: 12px;
}
</style>
<h1 class="font-2xl">Timesheets</h1>
<div>
<table>
	<thead>
		<tr>
			<th class="border-left">Calendario</th>
			<th>Tipo</th>
			<th>Day in</th>
			<th class="border-right">Day out</th>
		</tr>
	</thead>
	<tbody>
		@foreach($timesheets as $value){
			<tr>
				<td>{{ $value->calendar->name }}</td>
				<td>{{ $value->type }}</td>
				<td>{{ $value->day_in }}</td>
				<td>{{ $value->day_out }}</td>
			</tr>
		}
		@endforeach
	</tbody>
</table>
</div>