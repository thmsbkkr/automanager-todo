import React, { Component } from 'react'

export default class Task extends Component {
  constructor(props) {
    super(props)

    this.state = {
      editText: this.props.task.body
    }

    this.ESCAPE_KEY = 27
    this.ENTER_KEY = 13
  }


  handleEdit () {
    this.props.onEdit()

    this.setState({ editText: this.props.task.body });
  }


  handleChange (event) {
    if (this.props.editing) {
      this.setState({ editText: event.target.value });
    }
  }


  handleKeyDown (event) {
    if (event.which === this.ESCAPE_KEY) {
      this.setState({ editText: this.props.task.body });

      this.props.onCancel(event);
    } else if (event.which === this.ENTER_KEY) {
      this.handleSubmit(event);
    }
  }


  handleSubmit (event) {
    let editText = this.state.editText.trim();

    if (editText) {
      this.props.onSave(editText);

      this.setState({ editText });
    } else {
      // this.props.onDestroy();
    }
  }


  render() {
    let body

    if (this.props.editing) {
      body = (
        <input
          ref="editField"
          className="form-control"
          value={this.state.editText}
          onBlur={this.handleSubmit.bind(this)}
          onChange={this.handleChange.bind(this)}
          onKeyDown={this.handleKeyDown.bind(this)}
          autoFocus={true}
        />
      )
    } else {
      body = this.props.task.body
    }

    return (
      <li className="list-group-item">
        <div className="d-flex align-items-center justify-content-between">
          <div className="flex-grow-1 mr-4" onDoubleClick={this.handleEdit.bind(this)}>
            {body}
          </div>

          <div className="d-flex align-items-center">
            <input
              className="d-inline mr-3"
              type="checkbox"
              checked={this.props.task.completed}
              onChange={this.props.onToggle} />

            <button
              className="d-inline btn btn-sm btn-danger"
              onClick={this.props.onDestroy}
            >Remove</button>
          </div>
        </div>
      </li>
    )
  }
}
