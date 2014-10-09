
{{ content() }}

<div class="row">

    <div class="span6">
        <div class="page-header">
            <h2>登录</h2>
        </div>
        {{ form('session/start') }}
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="email">机构</label>
                    <div class="controls">
                        {{ text_field('agency', 'class': "span5") }}
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">用户名</label>
                    <div class="controls">
                        {{ text_field('username', 'class': "span5") }}
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="password">密码</label>
                    <div class="controls">
                        {{ password_field('password', 'class': "span5") }}
                    </div>
                </div>
                <div class="control-group">
                    {{ submit_button('登录', 'class': 'btn btn-primary btn-large') }}
                </div>
            </fieldset>
        </form>
    </div>
	
</div>
