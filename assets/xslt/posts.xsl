<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <xsl:for-each select="postsdata/posts/post">
        <xsl:apply-templates select="pagination" />
        <xsl:apply-templates select="data" />
    </xsl:for-each>  
    <xsl:apply-templates select="postsdata/pagination" />
</xsl:template>

<xsl:template match="post/data">
    <xsl:element name="div">
        <xsl:attribute name="class">
            post_container
        </xsl:attribute>
        <xsl:attribute name="style">
            margin-left: <xsl:value-of select="../indent" />%
        </xsl:attribute>
        <xsl:attribute name="id">
            <xsl:value-of select="../id" />
        </xsl:attribute>
        <h5>
			<xsl:value-of select="author" /> -
            <xsl:value-of select="edittime" /><xsl:text> </xsl:text><!-- - 
            user[<xsl:value-of select="author" />] - 
            id[<xsl:value-of select="../id" />] - 
            parent[<xsl:value-of select="parentId" />]-->
            <xsl:apply-templates select="addpost" /><xsl:text> </xsl:text>
            <xsl:apply-templates select="editpost" /><xsl:text> </xsl:text>
            <xsl:apply-templates select="delpost" />
        </h5>    
        <p><xsl:value-of select="content" /></p>
    </xsl:element>   
</xsl:template>

<xsl:template match="post/pagination">
    <xsl:element name="div">
        <xsl:attribute name="class">
            post_container
        </xsl:attribute>
        <xsl:attribute name="style">
            margin-left: <xsl:value-of select="../indent" />%
        </xsl:attribute>
        <xsl:attribute name="id">
            <xsl:value-of select="../id" />
        </xsl:attribute>
        <xsl:apply-templates select="nextpage" />
        <xsl:apply-templates select="ajaxnext" />
        <xsl:apply-templates select="deeperpage" />
        <xsl:apply-templates select="ajaxdeeper" />
    </xsl:element>
</xsl:template>

<xsl:template match="postsdata/pagination">
    <xsl:element name="div">
        <xsl:attribute name="class">
            post_container
        </xsl:attribute>
        <xsl:attribute name="style">
            margin-left: <xsl:value-of select="../info/rootPostIndent" />%
        </xsl:attribute>
        <xsl:attribute name="id">
            <xsl:value-of select="../info/rootPostId" />-<xsl:value-of select="../info/pageNr + 1" />
        </xsl:attribute>
        <xsl:apply-templates select="prevpage" />
        <xsl:apply-templates select="nextpage" />
        <xsl:apply-templates select="ajaxnext" />
        
    </xsl:element>
</xsl:template>

<xsl:template match="ajaxdeeper">
    <xsl:element name="button">
        <xsl:attribute name="onclick">
            loadPostContent(<xsl:value-of select="onclickParam"/>)
        </xsl:attribute>
        <xsl:attribute name="class">
            ajax_button
        </xsl:attribute>
        Ajax sügavamale
    </xsl:element>     
</xsl:template>

<xsl:template match="deeperpage">
    <xsl:element name="a">
        <xsl:attribute name="class">
            post_normal_a
        </xsl:attribute>
        <xsl:attribute name="href">
            <xsl:value-of select="href"/>
        </xsl:attribute>
        Sügavamale
    </xsl:element>
</xsl:template>

<xsl:template match="ajaxnext">
    <xsl:element name="button">
        <xsl:attribute name="onclick">
            loadPostContent(<xsl:value-of select="onclickParam"/>)
        </xsl:attribute>
        <xsl:attribute name="class">
            ajax_button
        </xsl:attribute>
        Ajax edasi
    </xsl:element>    
</xsl:template>

<xsl:template match="nextpage">
    <xsl:element name="a">
        <xsl:attribute name="class">
            post_normal_a
        </xsl:attribute>
        <xsl:attribute name="href">
            <xsl:value-of select="href"/>
        </xsl:attribute>
        Edasi
    </xsl:element> 
</xsl:template>

<xsl:template match="prevpage">
    <xsl:element name="a">
        <xsl:attribute name="class">
            post_normal_a
        </xsl:attribute>
        <xsl:attribute name="href">
            <xsl:value-of select="href"/>
        </xsl:attribute>
        Tagasi
    </xsl:element>
</xsl:template>

<xsl:template match="addpost">
    <xsl:element name="a">
        <xsl:attribute name="class">
            btn-success
        </xsl:attribute>
        <xsl:attribute name="href">
            <xsl:value-of select="href"/>
        </xsl:attribute>
        <xsl:value-of select="text" />
    </xsl:element>
</xsl:template>

<xsl:template match="editpost">
    <xsl:element name="a">
        <xsl:attribute name="class">
            btn-primary
        </xsl:attribute>
        <xsl:attribute name="href">
            <xsl:value-of select="href"/>
        </xsl:attribute>
        <xsl:value-of select="text" />
    </xsl:element>
</xsl:template>

<xsl:template match="delpost">
    <xsl:element name="a">
        <xsl:attribute name="class">
           btn-danger
        </xsl:attribute>
        <xsl:attribute name="href">
            <xsl:value-of select="href"/>
        </xsl:attribute>
        <xsl:value-of select="text" />
    </xsl:element>
</xsl:template>

</xsl:stylesheet> 