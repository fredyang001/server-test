<div class="panel panel-primary">
	<div class="panel-heading"><strong>Factory Work Services on {umbrella}</strong></div>
	<div class="panel-body row">
		<div class="col-md-2">
			<ol>
				<li><a href="/testwork/registerme">registerme</a></li>
				<li><a href="/testwork/buybox">buybox</a></li>
				<li><a href="/testwork/mybuilds">mybuilds</a></li>
				<li><a href="/testwork/recycle">recycle</a></li>
				<li><a href="/testwork/buymybot">buymybot</a></li>
				<li><a href="/testwork/rebootme">rebootme</a></li>
				<li><a href="/testwork/goodbye">goodbye</a></li>
			</ol>
		</div>
		<div class="col-md-3">
			<div><strong>Parameters:</strong></div>
			{workparms}
			<div>{key} = {value}</div>
			{/workparms}
		</div>
		<div class="col-md-7">
			<div><strong>Result:</strong></div>
			<pre>{workresult}</pre>
		</div>
	</div>
</div>

<div class="panel panel-info">
	<div class="panel-heading"><strong>Test App State</strong></div>
	<div class="panel-body">
		<div>Balance : {balance}</div>
		<div>Parts:</div>
		<div class="row">
			{parts}
			<div class="col-md-3">
				{id} ({type})
			</div>
			{/parts}
		</div>
	</div>
</div>
