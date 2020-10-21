<template>
    <div style="margin-left: 20px">
        <div id="blog">
            <h1>Eloquent Relationships</h1>
            <div class="blogBody">
                <p>Eloquent is a powerful Laravel ORM, and it allows to define relationships pretty easily. But do you know all about its functionality? Let’s check it in this ultimate guide, which will cover all types – one-to-one, one-to-many, many-to-many, and polymorphic relations.
                </p>
                <p>In addition to the article, each section will have a mini demo-project with link to GitHub and video explanation.</p>
            </div>

            <div class="blogBody">
                <h2>1. Intro: DB and Foreign Keys</h2>
                <p>Let’s start with basic database theory, almost unrelated to Laravel.</p>
                <p>To have relationships between database tables, first you still need to take care of database <b>fields</b> and <b>foreign keys</b>. Usually, in database migration statement it looks something like this:</p>
            </div>
            <pre class="blogPre"><code class="blogCode"> Schema::table('posts', function (Blueprint $table) {
   $table-&gt;integer('user_id')-&gt;unsigned();
   $table-&gt;foreign('user_id')-&gt;references('id')-&gt;on('users');
 });
</code></pre>
            <div class="blogBody">
                <p>In this example we’re defining posts.user_id field with foreign key to users.id field.</p>
                <p>In pure MySQL, it would look like this:</p>
            </div>
            <pre class="blogPre"><code class="blogCode"> ALTER TABLE posts
 ADD FOREIGN KEY (user_id) REFERENCES users(id);
</code></pre>
            <div class="blogBody">
                <p>Important thing: we also may specify the behavior for the <b>delete</b> and <b>update</b> actions on related tables. In other words, if we delete a user, what should happen to their posts?</p>
                <ul>
                    <li><b>CASCADE</b>: deletes/updates child entry along with the parent entry</li>
                    <li><b>RESTRICT</b>: throws error and doesn’t delete/updates parent entry</li>
                    <li><b>SET NULL</b>: deletes parent entry and sets child foreign key entry to NULL</li>
                </ul>
            </div>
            <div class="blogBody">
                <p><b>Notice</b>: there are more options but they depend on database system and settings.</p>
                <p>Here’s how it looks in Laravel migrations:</p>
            </div>
            <pre class="blogPre"><code class="blogCode"> $table-&gt;foreign('user_id')
    -&gt;references('id')-&gt;on('users')
    -&gt;onDelete('cascade');
</code></pre>
            <div class="blogBody">
                <ul>
                    <li>Advanced Subqueries</li>
                    <li>Mass Assignment</li>
                </ul>
            </div>
            <div class="blogBody">
                <h2>Relationship</h2>
                <div style="margin-left: 20px">
                    <ul>
                        <li>One to One</li>
                        <li>One to Many</li>
                        <li>Many to Many</li>
                    </ul>
                </div>

            </div>
            <div class="blogBody">
                <h3 id="many-to-many"><a href="#many-to-many">Many To Many</a></h3>
                <p>Many-to-many relations are slightly more complicated than <code>hasOne</code> and <code>hasMany</code> relationships.
                    An example of such a relationship is a user with many roles, where the roles are also shared by other users.
                    For example, many users may have the role of "Admin".</p>
                <h4>Table Structure</h4>
                <p>To define this relationship, three database tables are needed: <code>users</code>, <code>roles</code>, and <code>role_user</code>.
                The <code>role_user</code> table is derived from the alphabetical order of the related model
                    names, and contains the <code>user_id</code> and <code>role_id</code> columns:</p>
                <pre class="blogPre" ><code class="blogCode"> users
   id - integer
   name - string
 roles
   id - integer
   name - string
 role_user
   user_id - integer
   role_id - integer
</code></pre>
                <h4>Model Structure</h4>
                <p>Many-to-many relationships are defined by writing a method
                    that returns the result of the <code>belongsToMany</code> method.
                    For example, let's define the <code>roles</code> method on our <code>User</code> model:</p>
                <pre class=" language-php"><code class=" language-php"><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Models</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment">/**
     * The roles that belong to the user.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">roles</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'App\Models\Role'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></span></code></pre>
                <p>
                    Once the relationship is defined,
                    you may access the user's roles using the <code>roles</code> dynamic property:
                </p>
                <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> App\<span class="token package">Models<span class="token punctuation">\</span>User</span><span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">find</span><span class="token punctuation">(</span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">roles</span> <span class="token keyword">as</span> <span class="token variable">$role</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token comment">//</span>
<span class="token punctuation">}</span></code></pre>
                <p>
                    Like all other relationship types,
                    you may call the <code>roles</code> method to continue chaining query constraints onto the relationship:
                </p>
                <pre class=" language-php"><code class=" language-php"><span class="token variable">$roles</span> <span class="token operator">=</span> App\<span class="token package">Models<span class="token punctuation">\</span>User</span><span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">find</span><span class="token punctuation">(</span><span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">orderBy</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'name'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
                <p>
                    As mentioned previously, to determine the table name of the relationship's joining table,
                    Eloquent will join the two related model names in alphabetical order.
                    However, you are free to override this convention.
                    You may do so by passing a second argument to the <code>belongsToMany</code> method:
                </p>
                <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'App\Models\Role'</span><span class="token punctuation">,</span> <span class="token single-quoted-string string">'role_user'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
                <p>
                    In addition to customizing the name of the joining table,
                    you may also customize the column names of the keys on the table by passing
                    additional arguments to the <code>belongsToMany</code> method. The third argument is the
                    foreign key name of the model on which you are defining the relationship,
                    while the fourth argument is the foreign key name of the model that you are joining to:
                </p>
                <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'App\Models\Role'</span><span class="token punctuation">,</span> <span class="token single-quoted-string string">'role_user'</span><span class="token punctuation">,</span> <span class="token single-quoted-string string">'user_id'</span><span class="token punctuation">,</span> <span class="token single-quoted-string string">'role_id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
                <h4>Defining The Inverse Of The Relationship</h4>
                <p>
                    To define the inverse of a many-to-many relationship,
                    you place another call to <code>belongsToMany</code> on your related model.
                    To continue our user roles example,
                    let's define the <code>users</code> method on the <code>Role</code> model:
                </p>
                <pre class=" language-php"><code class=" language-php"><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Models</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Role</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment">/**
     * The users that belong to the role.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">users</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'App\Models\User'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></span></code></pre>
                <p>
                    As you can see, the relationship is defined exactly the same as its <code>User</code> counterpart,
                    with the exception of referencing the <code>App\Models\User</code> model.
                    Since we're reusing the <code>belongsToMany</code> method, all of the usual table and key
                    customization options are available when defining the inverse of many-to-many relationships.
                </p>
                <h4>Retrieving Intermediate Table Columns</h4>
                <p>
                    As you have already learned, working with many-to-many relations requires the presence of an intermediate table.
                    Eloquent provides some very helpful ways of interacting with this table. For example,
                    let's assume our <code>User</code> object has many <code>Role</code> objects that it is related to. After accessing this relationship,
                    we may access the intermediate table using the <code>pivot</code> attribute on the models:
                </p>
                <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> App\<span class="token package">Models<span class="token punctuation">\</span>User</span><span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">find</span><span class="token punctuation">(</span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">roles</span> <span class="token keyword">as</span> <span class="token variable">$role</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">echo</span> <span class="token variable">$role</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">pivot</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">created_at</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
                <p>
                    Notice that each <code>Role</code> model we retrieve is automatically assigned a <code>pivot</code> attribute.
                    This attribute contains a model representing the intermediate table, and may be used like any other Eloquent model.
                </p>
                <p>
                    By default, only the model keys will be present on the pivot object.
                    If your <code>pivot</code> table contains extra attributes, you must specify them when defining the relationship:
                </p>
                <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'App\Models\Role'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withPivot</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'column1'</span><span class="token punctuation">,</span> <span class="token single-quoted-string string">'column2'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
                <p>
                    If you want your pivot table to have automatically maintained <code>created_at</code> and <code>updated_at</code> timestamps,
                    use the <code>withTimestamps</code> method on the relationship definition:
                </p>
                <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany</span><span class="token punctuation">(</span><span class="token single-quoted-string string">'App\Models\Role'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withTimestamps</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
                <div class="ivu-alert ivu-alert-warning ivu-alert-with-icon ivu-alert-with-desc"><span class="ivu-alert-icon"><i class="ivu-icon ivu-icon-ios-alert-outline"></i></span> <span class="ivu-alert-message">
                Important Tips
                </span> <span class="ivu-alert-desc">
                    When using timestamps on pivot tables, the table is required to have both <code>created_at</code> and <code>updated_at</code> timestamp columns.
                </span> <!---->
                </div>

                <h4>Customizing The <code>pivot</code> Attribute Name</h4>

            </div>
        </div>

    </div>
</template>
